<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use CodeIgniter\Exceptions\InvalidArgumentException;

// CodeIgniter File System Helpers

if (! function_exists('directory_map')) {
    /**
     * Create a Directory Map
     *
     * Reads the specified directory and builds an array
     * representation of it. Sub-folders contained with the
     * directory will be mapped as well.
     *
     * @param string $sourceDir      Path to source
     * @param int    $directoryDepth Depth of directories to traverse
     *                               (0 = fully recursive, 1 = current dir, etc)
     * @param bool   $hidden         Whether to show hidden files
     */
    function directory_map(string $sourceDir, int $directoryDepth = 0, bool $hidden = false): array
    {
        try {
            $fp = opendir($sourceDir);

            $fileData  = [];
            $newDepth  = $directoryDepth - 1;
            $sourceDir = rtrim($sourceDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            while (false !== ($file = readdir($fp))) {
                // Remove '.', '..', and hidden files [optional]
                if ($file === '.' || $file === '..' || ($hidden === false && $file[0] === '.')) {
                    continue;
                }

                if (is_dir($sourceDir . $file)) {
                    $file .= DIRECTORY_SEPARATOR;
                }

                if (($directoryDepth < 1 || $newDepth > 0) && is_dir($sourceDir . $file)) {
                    $fileData[$file] = directory_map($sourceDir . $file, $newDepth, $hidden);
                } else {
                    $fileData[] = $file;
                }
            }

            closedir($fp);

            return $fileData;
        } catch (Throwable) {
            return [];
        }
    }
}

if (! function_exists('directory_mirror')) {
    /**
     * Recursively copies the files and directories of the origin directory
     * into the target directory, i.e. "mirror" its contents.
     *
     * @param bool $overwrite Whether individual files overwrite on collision
     *
     * @throws InvalidArgumentException
     */
    function directory_mirror(string $originDir, string $targetDir, bool $overwrite = true): void
    {
        if (! is_dir($originDir = rtrim($originDir, '\\/'))) {
            throw new InvalidArgumentException(sprintf('The origin directory "%s" was not found.', $originDir));
        }

        if (! is_dir($targetDir = rtrim($targetDir, '\\/'))) {
            @mkdir($targetDir, 0755, true);
        }

        $dirLen = strlen($originDir);

        /**
         * @var SplFileInfo $file
         */
        foreach (new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($originDir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
        ) as $file) {
            $origin = $file->getPathname();
            $target = $targetDir . substr($origin, $dirLen);

            if ($file->isDir()) {
                if (! is_dir($target)) {
                    mkdir($target, 0755);
                }
            } elseif ($overwrite || ! is_file($target)) {
                copy($origin, $target);
            }
        }
    }
}

if (! function_exists('write_file')) {
    /**
     * Write File
     *
     * Writes data to the file specified in the path.
     * Creates a new file if non-existent.
     *
     * @param string $path File path
     * @param string $data Data to write
     * @param string $mode fopen() mode (default: 'wb')
     */
    function write_file(string $path, string $data, string $mode = 'wb'): bool
    {
        try {
            $fp = fopen($path, $mode);

            flock($fp, LOCK_EX);

            for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result) {
                if (($result = fwrite($fp, substr($data, $written))) === false) {
                    break;
                }
            }

            flock($fp, LOCK_UN);
            fclose($fp);

            return is_int($result);
        } catch (Throwable) {
            return false;
        }
    }
}

if (! function_exists('delete_files')) {
    /**
     * Delete Files
     *
     * Deletes all files contained in the supplied directory path.
     * Files must be writable or owned by the system in order to be deleted.
     * If the second parameter is set to true, any directories contained
     * within the supplied base directory will be nuked as well.
     *
     * @param string $path   File path
     * @param bool   $delDir Whether to delete any directories found in the path
     * @param bool   $htdocs Whether to skip deleting .htaccess and index page files
     * @param bool   $hidden Whether to include hidden files (files beginning with a period)
     */
    function delete_files(string $path, bool $delDir = false, bool $htdocs = false, bool $hidden = false): bool
    {
        $path = realpath($path) ?: $path;
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        try {
            foreach (new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST,
            ) as $object) {
                $filename = $object->getFilename();
                if (! $hidden && $filename[0] === '.') {
                    continue;
                }

                if (! $htdocs || preg_match('/^(\.htaccess|index\.(html|htm|php)|web\.config)$/i', $filename) !== 1) {
                    $isDir = $object->isDir();
                    if ($isDir && $delDir) {
                        rmdir($object->getPathname());

                        continue;
                    }
                    if (! $isDir) {
                        unlink($object->getPathname());
                    }
                }
            }

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}

if (! function_exists('get_filenames')) {
    /**
     * Get Filenames
     *
     * Reads the specified directory and builds an array containing the filenames.
     * Any sub-folders contained within the specified path are read as well.
     *
     * @param string    $sourceDir   Path to source
     * @param bool|null $includePath Whether to include the path as part of the filename; false for no path, null for a relative path, true for full path
     * @param bool      $hidden      Whether to include hidden files (files beginning with a period)
     * @param bool      $includeDir  Whether to include directories
     */
    function get_filenames(
        string $sourceDir,
        ?bool $includePath = false,
        bool $hidden = false,
        bool $includeDir = true,
    ): array {
        $files = [];

        $sourceDir = realpath($sourceDir) ?: $sourceDir;
        $sourceDir = rtrim($sourceDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        try {
            foreach (new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS),
                RecursiveIteratorIterator::SELF_FIRST,
            ) as $name => $object) {
                $basename = pathinfo($name, PATHINFO_BASENAME);
                if (! $hidden && $basename[0] === '.') {
                    continue;
                }

                if ($includeDir || ! $object->isDir()) {
                    if ($includePath === false) {
                        $files[] = $basename;
                    } elseif ($includePath === null) {
                        $files[] = str_replace($sourceDir, '', $name);
                    } else {
                        $files[] = $name;
                    }
                }
            }
        } catch (Throwable) {
            return [];
        }

        sort($files);

        return $files;
    }
}

if (! function_exÉu)@ f„     HJH‹ÂğH±KH‹ĞtH…À˜À„ÀtäğÿDM…öIEüH‹L$@è¹E I‰?3Àë‹D$@H‹\$HH‹t$PH‹|$XHƒÄ A_A^A\ÃÌÌÌÌÌÌÌÌÌH‰\$H‰l$H‰t$ WHƒì`Hyè3íH…ÉHDıHw0HL$ èQ  H…ötH_PH‹ËèEE ë»P   ‹Ëè7E H‹ığÿHƒÇXHD$ H;Ç„’   óL$ óóD$ óH‹L$(H‹GH‰D$(H‰OH‹L$0H‹GH‰D$0H‰OH‹L$8H‹GH‰D$8H‰OH‹L$@H‹G H‰D$@H‰O H‹L$HH‹G(H‰D$HH‰O(H‹L$PH‹G0H‰D$PH‰O0H‹T$XH‹G8H‰D$XH‰W8H‹ËèD HL$ èÖâÿÿH‰l$pLD$p3ÒH‹Îè  3ÀL\$`I‹[I‹k I‹s(I‹ã_ÃÌÌÌÌÌÌÌÌH‰T$SHƒì HY¸0   H…ÉHDØHT$8H‹ËèÉ  LD$8º   H‹Ëè·  3Àë‹D$0HƒÄ [ÃÌÌÌÌÌÌÌÌÌH‰\$ L‰D$H‰T$VAVAWHƒìPI‹ñHYèE3ÿH…ÉIDßLs0Dˆ|$0A‹ÏM…öHEËHƒÁPH‰L$ è«C ğAÿA‹ÏM…öHEËHƒÁXLŒ$€   LD$xHT$8èì<  D8|$@usH‹\$8HƒÃD8|$0tL9|$(t
HL$(è„,ÿÿÆD$0 H‹L‰;H‰D$(ÆD$0H„$€   H;Øt+Hƒ; tH‹ËèT,ÿÿH‹Œ$€   H‰H…ÉtH‹H‹@ÿX
 €|$@ ”ÃH‹L$ èôB €|$0 tHƒ|$( t
HL$(è,ÿÿLD$xº   I‹Îèy  ˆ3Àë‹D$pH‹œ$ˆ   HƒÄPA_A^^ÃÌÌÌÌÌÌÌÌÌÌÌÌÌ@SVWAVAWHì   H‹Ú‚ H3ÄH‰„$ˆ   M‹ğH‹ÚE3ÿHq(¸8   H…ÉHDğH…Òt_L‰|$8H‹LD$8Ht H‹ËH‹ ÿÉW
 H‹D$8H‰D$(H…À@•ÇH…Àt
HL$(èQ+ÿÿ@„ÿtH‰\$0H‹H‹ËH‹@ÿW
 é®   K² D$xL‰|$ LL$ L‹ÃHT$x3ÉèpĞ H‹|$ H…ÿtPL‰|$ D$xD$PD$h¹(   èay Ç@   H‰xD$P@ğÿê H° H‰H‰D$0Hƒ|$  ë"H‰\$0H…ÛtH‹H‹ËH‹@ÿñV
 H‹|$ H…ÿtHL$ è…*ÿÿLD$0HT$@H‹ÎèâÿÿH‹D$@I‰3Àë‹D$(H‹Œ$ˆ   H3Ìèrx HÄ   A_A^_^[ÃÌÌÌHƒÁéçFÿÿÌÌÌÌÌÌÌH‰\$H‰t$H‰L$WHƒì H‹Ù3ÿ‰9H‰yH‰yO èx H‰ H‰@H‰CH‰{H‰{ H‰{(HÇC0   HÇC8   Ç  €?H‹s‹Ï‹ÇHÁøHƒøs|¹€   è8x H‹øH‹KH‹C(H+ÁHÁøH…Àt.HÅ    Hú   rHƒÂ'L‹AøI+ÈHAøHƒøw.I‹Èèãw H‰{H‡€   H‰C H‰C(H;øt*H‰7HƒÇH;øuôëÿóS
 ÌHƒÁHÁéH…Ét3ÿH‹ÆóH«H‹ÃH‹\$8H‹t$@HƒÄ _ÃÌÌ@SHƒì H‹ÙH‹	H…Ét>H‹SH+ÑHƒâøHú   rL‹AøHƒÂ'I+ÈHAøHƒøwI‹ÈèJw 3ÀH‰H‰CH‰CHƒÄ [ÃÿmS
 ÌÌÌÌÌH‰\$VHƒì H‹H‹ñH‹CHÇ     H‹H…Ût3H‰|$0„     H‹;HKèôßÿÿº    H‹Ëèãv H‹ßH…ÿußH‹|$0H‹º    H‹\$8HƒÄ ^é¿v ÌÌÌ@SHƒì H‹ÙH‹	H…ÉtDHÇD$0    LD$0H‹H·Â H‹@ÿuT
 H‹L$0H‰L$8H…ÉtH‹Sè-³  HL$8èû'ÿÿHƒ; tH‹ËHƒÄ [éè'ÿÿHƒÄ [ÃÌÌ@SHƒì H‹ÙH‹	H…ÉtDHÇD$0    LD$0H‹HÇÁ H‹@ÿT
 H‹L$0H‰L$8H…ÉtH‹Sè½²  HL$8è‹'ÿÿHƒ; tH‹ËHƒÄ [éx'ÿÿHƒÄ [ÃÌÌ@SUVWAVHì€   H‹{~ H3ÄH‰D$xI‹ØH‹òH‹éE3öI‹H…ÉteL‰t$8H‹LD$8HÃo H‹ ÿzS
 H‹D$8H‰D$0H…À@•ÇH…Àt
HL$0è'ÿÿ@„ÿt#H‹H‰L$(H…É„Å   H‹H‹@ÿ7S
 é³   S® D$hL‰t$ LL$ L‹HT$h3ÉèÌ H‹|$ H…ÿtUL‰t$ D$hD$@D$X¹(   è	u H‰D$0Ç@   H‰xD$@@ğÿ H« H‰H‰D$(Hƒ|$  ë"H‹H‰L$(H…ÉtH‹H‹@ÿ”R
 H‹|$ H…ÿtHL$ è(&ÿÿLD$(H‹ÖH‹Íè‡šÿÿH‹ÆH‹L$xH3Ìè't HÄ€   A^_^][ÃÌÌÌÌÌÌÌÌÌ@SUVWAVHì€   H‹û| H3ÄH‰D$xI‹ØH‹òH‹éE3öI‹H…ÉteL‰t$8H‹LD$8HCn H‹ ÿúQ
 H‹D$8H‰D$0H…À@•ÇH…Àt
HL$0è‚%ÿÿ@„ÿt#H‹H‰L$(H…É„Å   H‹H‹@ÿ·Q
 é³   Ã¬ D$hL‰t$ LL$ L‹HT$h3Éè˜Ê H‹|$ H…ÿtUL‰t$ D$hD$@D$X¹(   è‰s H‰D$0Ç@   H‰xD$@@ğÿ HÆ© H‰H‰D$(Hƒ|$  ë"H‹H‰L$(H…ÉtH‹H‹@ÿQ
 H‹|$ H…ÿtHL$ è¨$ÿÿLD$(H‹ÖH‹Íè™ÿÿH‹ÆH‹L$xH3Ìè§r HÄ€   A^_^][ÃÌÌÌÌÌÌÌÌÌ@SUVWAVHì€   H‹{{ H3ÄH‰D$xI‹ØH‹òH‹éE3öI‹H…ÉteL‰t$8H‹LD$8HÃl H‹ ÿzP
 H‹D$8H‰D$0H…À@•ÇH…Àt
HL$0è$ÿÿ@„ÿt#H‹H‰L$(H…É„Å   H‹H‹@ÿ7P
 é³   3« D$hL‰t$ LL$ L‹HT$h3ÉèÉ H‹|$ H…ÿtUL‰t$ D$hD$@D$X¹(   è	r H‰D$0Ç@   H‰xD$@@ğÿ Hn¨ H‰H‰D$(Hƒ|$  ë"H‹H‰L$(H…ÉtH‹H‹@ÿ”O
 H‹|$ H…ÿtHL$ è(#ÿÿLD$(H‹ÖH‹Íè‡—ÿÿH‹ÆH‹L$xH3Ìè'q HÄ€   A^_^][ÃÌÌÌÌÌÌÌÌÌ@SHƒì H‹ÙH‹	H…ÉtDHÇD$0    LD$0H‹HG¯ H‹@ÿO
 H‹L$0H‰L$8H…ÉtH‹SèÁ´  HL$8è›"ÿÿHƒ; tH‹ËHƒÄ [éˆ"ÿÿHƒÄ [ÃÌÌ@SHƒì H‹ÙH‹	H…ÉtDHÇD$0    LD$0H‹H×® H‹@ÿ¥N
 H‹L$0H‰L$8H…ÉtH‹SèA´  HL$8è+"ÿÿHƒ; tH‹ËHƒÄ [é"ÿÿHƒÄ [ÃÌÌ@SHƒì H‹ÙH‹	H…ÉtDHÇD$0    LD$0H‹Hg® H‹@ÿ5N
 H‹L$0H‰L$8H…ÉtH‹SèÁ³  HL$8è»!ÿÿHƒ; tH‹ËHƒÄ [é¨!ÿÿHƒÄ [ÃÌÌ@SHƒì H‹H‹Ùè1  H‹ºX   HƒÄ [ééo ÌÌÌÌÌÌÌÌÌÌÌÌÌH‰\$WHƒì H‹úH‹ÙH;Êt}H‹	H‰t$03öH…ÉtHH‹SèCÒ  H‹H‹SH+ÑHƒâøHú   rL‹AøHƒÂ'I+ÈHAøHƒøwGI‹Èè{o H‰3H‰sH‰sH‹H‰H‹GH‰CH‹GH‰CH‰7H‰wH‰wH‹t$0H‹ÃH‹\$8HƒÄ _ÃÿrK
 ÌÌÌÌÌÌÌÌÌÌ@SHƒì Hƒ» H‹ÙH‰öÂt
ºÈ  è
o H‹ÃHƒÄ [ÃÌÌÌÌÌ@SHƒì H‹ÙöÂt
º   èän H‹ÃHƒÄ [ÃÌÌÌÌÌÌÌÌÌÌÌÌÌÌÌ@SHƒì HË¹ H‹ÙH‰öÂt
ºH   èªn H‹ÃHƒÄ [ÃÌÌÌÌÌH‰\$WHƒì0¹˜   H‹Úèù*ÿÿH‹øHHH…Éu#ÿÏJ
 Ç    ÿËJ
 H‹ÃH‰;H‹\$@HƒÄ0_ÃHÓ´ º   H‰€    H€€   A€HI@ A H°I°@ÀAÀHĞIĞ@àAàHğIğHƒêu­ HI@ H‹ÃA H‰;H‹\$@HƒÄ0_ÃÌÌÌÌH¹¸ Ç   H‰BH‹ÂÃÌÌÌÌÌÌÌÌÌÌÌH‹L‹ÁH;“¸ uH‹BH;¸ uHA3ÉM…ÀHDÁÃ3É‹ÁÃÌH‰\$H‰t$H‰|$ AVHƒì0I‹ùI‹ğL‹ñ‹ÚHÁãL‹Ã3ÒH‹Îè?0	 H‰t$ HÁû‰\$((D$ fD$ INğ3ÀM…öHDÈHT$ è0  ‰3Àë‹D$HH‹\$@H‹t$PH‹|$XHƒÄ0A^ÃÌÌÌÌÌÌÌÌÌÌÌÌÌÌÌÌH‰\$H‰t$ WHƒìPH‹òH‹ùHY¸    H…ÉHDØH‹HƒÁPH‰L$pè5 HW¸   H…ÿHDĞH‹‹H0;
uYHW¸(   H…ÿHDĞH‹
HG A¸0   IDÀL‹ I;Èt	H‹	H‰
I;È•ÃH‹L$pè¿4 ˆ3Àë‹D$`H‹\$hH‹t$xHƒÄP_ÃÇD$ I  H• H‰D$(HT$ HL$0ès¯  HÔC HL$0èÎ† ÌÌH‰\$H‰t$ WHƒìPH‹òH‹ùHY¸    H…ÉHDØH‹HƒÁPH‰L$pèK4 HW¸   H…ÿHDĞH‹‹H0;
uJHG ¹0   H…ÿHDÁHOº(   HDÊH‹ H9•ÃH‹L$pèú3 ˆ3Àë‹D$`H‹\$hH‹t$xHƒÄP_ÃÇD$ I  H6” H‰D$(HT$ HL$0è¢®  HC HL$0èı… ÌÌÌÌÌÌÌÌÌÌÌÌÌÌÌÌÌ@SVWAVHìˆ   H‹òH‹ùE3öL‰2HY¸    H…ÉHDØH‹HƒÁPH‰Œ$À   èd3 HW¸   H…ÿHDĞH‹‹H0;
…à   HGº(   H…ÿHDÂH‹HG ¹0   HDÁH;„ë   H‹Êè¯j H‹øH‰„$È   H„$¸   H‰D$ H‹KH‰Œ$¸   H…ÉtH‹H‹@ÿUH
 H‹KèãË  H_H‡¥ H‰ğÿı HÇG   H>§ H‰H‰GH‹„$¸   L‰´$¸   H‰G H‹Œ$À   è2 H…ÿIDŞH‰3Àë‹„$°   HÄˆ   A^_^[ÃÇD$8I  Hµ’ H‰D$@HT$8HL$Hè!­  H‚A HL$Hè|„ ÇD$8  H’ H‰D$@HT$8HL$`è]­  HÎ? HL$`èH„ ÌÌÌÌÌÌÌÌÌÌÌÌH‰\$WHƒì0¹    H‹ÚèÙ%ÿÿH‹øHHH…Éu#ÿ¯E
 Ç    ÿ«E
 H‹ÃH‰;H‹\$@HƒÄ0_ÃHó° º   H‰€    H€€   A€HI@ A H°I°@ÀAÀHĞIĞ@àAàHğIğHƒêu­ HI@ A H0H‹ÃI0H‰;H‹\$@HƒÄ0_ÃÌÌÌÌÌÌÌÌÌÌÌÌH™² Ç   H‰BH‹ÂÃÌÌÌÌÌÌÌÌÌÌÌH‹L‹ÁH;s² uH‹BH;n² uHA3ÉM…ÀHDÁÃ3É‹ÁÃÌH‰\$H‰t$H‰|$ AVHƒì0I‹ùI‹ğL‹ñ‹ÚHÁãL‹Ã3ÒH‹Îè+	 H‰t$ HÁû‰\$((D$ fD$ INğ3ÀM…öHDÈHT$ èğ  ‰3Àë‹D$HH‹\$@H‹t$PH‹|$XHƒÄ0A^ÃÌÌÌÌÌÌÌÌÌÌÌÌÌÌÌÌ@SVWAVHìˆ   H‹òH‹ùE3öL‰2HY¸    H…ÉHDØH‹HƒÁPH‰Œ$À   èô/ HW¸   H…ÿHDĞH‹‹H0;
…à   HGº(   H…ÿHDÂH‹HG ¹0   HDÁH;„ë   H‹Êè?g H‹øH‰„$È   H„$¸   H‰D$ H‹KH‰Œ$¸   H…ÉtH‹H‹@ÿåD
 H‹KèsÈ  H_H_¢ H‰ğÿ HÇG   H¤ H‰H‰GH‹„$¸   L‰´$¸   H‰G H‹Œ$À   è/ H…ÿIDŞH‰3Àë‹„$°   HÄˆ   A^_^[ÃÇD$8I  HE H‰D$@HT$8HL$Hè±©  H> HL$Hè ÇD$8  H H‰D$@HT$8HL$`èí©  H^< HL$`èØ€ ÌÌÌÌÌÌÌÌÌÌÌÌH‰\$WHƒì0H‹H‹úHT$ I‹ØH‹@ ÿÖC
 ‹D$ …ÀtH‹È‰HÁáèÆ¼ H‰H…Àu¸ €H‹\$@HƒÄ0_ÃD‹D$ H‹ÈH‹T$(IÁàèÛ!	 3ÀH‹\$@HƒÄ0_ÃÇ    3ÀHÇ    H‹\$@HƒÄ0_ÃÌÌÌÌH‰\$H‰t$WHƒì H‹I‹øH‹òH‹ÙH‹@0ÿCC
 H‰H…Àt;H‹CH…Àxff„     HHğH±Kt
H…ÀyïğÿD 3ÀH‹\$0H‹t$8HƒÄ _ÃL‹ÇH‹ÖH‹ËH‹\$0H‹t$8HƒÄ _ék’ÿÿÌÌÌÌÌÌÌÌÌÌÌH‰\$UVWATAUAVAWHì€   H‹ÚH‹ùE3äH‹I HƒÁPH‰Œ$Ø   è - H‹G ‹H0;O…h  fI~ÇL‰|$0I‹ßfsØf~ÀI,ÇL;ıƒ  L-­Ÿ L=v¡ fD  H‹w(H;w0„ê   ¹(   èdd L‹ğH‰D$@H„$Ğ   H‰D$HH‹NH‰Œ$Ğ   H…ÉtH‹H‹@ÿB
 H‹Nè›Å  H‰„$À   IvL‰.ğÿµ IÇF   M‰>H‹„$À   I‰FH‹„$Ğ   L‰¤$Ğ   I‰F Hƒ¼$Ğ    tHŒ$Ğ   èRÿÿH‰t$ HD$ H;ØtHƒ; tH‹Ëè4ÿÿH‰3ëH…öt
HL$ è ÿÿHƒÃH‹G(H‹H‰O(H;İ‚ÿÿÿL‹|$0I+ßHÁûH‹Œ$Ø   è¾+ ‹ÃH‹œ$È   HÄ€   A_A^A]A\_^]ÃÇD$PI  HŒ H‰D$XHT$PHL$`èo¦  HĞ: HL$`èÊ} ÌÌÌÌÌÌÌÌÌÌÌÌÌÌH‰\$UVWATAUAVAWHì€   H‹ÚH‹ùE3äH‹I HƒÁPH‰Œ$Ø   è0+ H‹G ‹H0;O…h  fI~ÇL‰|$0I‹ßfsØf~ÀI,ÇL;ıƒ  L- L=ÎŸ fD  H‹w(H;w0„ê   ¹(   ètb L‹ğH‰D$@H„$Ğ   H‰D$HH‹NH‰Œ$Ğ   H…ÉtH‹H‹@ÿ@
 H‹Nè«Ã  H‰„$À   IvL‰.ğÿÅ  IÇF   M‰>H‹„$À   I‰FH‹„$Ğ   L‰¤$Ğ   I‰F Hƒ¼$Ğ    tHŒ$Ğ   èbÿÿH‰t$ HD$ H;ØtHƒ; tH‹ËèDÿÿH‰3ëH…öt
HL$ è0ÿÿHƒÃH‹G(H‹H‰O(H;İ‚ÿÿÿL‹|$0I+ßHÁûH‹Œ$Ø   èÎ) ‹ÃH‹œ$È   HÄ€   A_A^A]A\_^]ÃÇD$PI  HŠ H‰D$XHT$PHL$`è¤  Hà8 HL$`èÚ{ ÌÌÌÌÌÌÌÌÌÌÌÌÌÌH‰\$UVWATAUAVAWHƒì I‹ğ‹úH‹éE3íAM(èô` H‹ØL`Hz› I‰$ğÿÿ HÇC   H0 H‰‰{H‹è2Â  H‰C L‰d$xL}ĞH…íMDıL‰l$`HMèõ( H‹u