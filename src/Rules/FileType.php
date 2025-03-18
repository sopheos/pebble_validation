<?php

namespace Pebble\Validation\Rules;

class FileType extends Rule
{
    private static $mimes = [
        '3g2'   => ['video/3gpp2'],
        '3gp'   => ['video/3gp', 'video/3gpp'],
        '7zip'  => ['application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip'],
        'aac'   => ['audio/x-acc'],
        'ac3'   => ['audio/ac3'],
        'ai'    => ['application/pdf', 'application/postscript'],
        'aif'   => ['audio/x-aiff', 'audio/aiff'],
        'aifc'  => ['audio/x-aiff'],
        'aiff'  => ['audio/x-aiff', 'audio/aiff'],
        'au'    => ['audio/x-au'],
        'avi'   => ['video/x-msvideo', 'video/msvideo', 'video/avi', 'application/x-troff-msvideo'],
        'avif'  => ['image/avif'],
        'bin'   => ['application/macbinary', 'application/mac-binary', 'application/octet-stream', 'application/x-binary', 'application/x-macbinary'],
        'bmp'   => ['image/bmp', 'image/x-bmp', 'image/x-bitmap', 'image/x-xbitmap', 'image/x-win-bitmap', 'image/x-windows-bmp', 'image/ms-bmp', 'image/x-ms-bmp', 'application/bmp', 'application/x-bmp', 'application/x-win-bitmap'],
        'cdr'   => ['application/cdr', 'application/coreldraw', 'application/x-cdr', 'application/x-coreldraw', 'image/cdr', 'image/x-cdr', 'zz-application/zz-winassoc-cdr'],
        'cer'   => ['application/pkix-cert', 'application/x-x509-ca-cert'],
        'class' => ['application/octet-stream'],
        'cpt'   => ['application/mac-compactpro'],
        'crl'   => ['application/pkix-crl', 'application/pkcs-crl'],
        'crt'   => ['application/x-x509-ca-cert', 'application/x-x509-user-cert', 'application/pkix-cert'],
        'csr'   => ['application/octet-stream'],
        'css'   => ['text/css', 'text/plain'],
        'csv'   => ['text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'],
        'dcr'   => ['application/x-director'],
        'der'   => ['application/x-x509-ca-cert'],
        'dir'   => ['application/x-director'],
        'dll'   => ['application/octet-stream'],
        'dms'   => ['application/octet-stream'],
        'doc'   => ['application/msword', 'application/vnd.ms-office'],
        'docx'  => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword', 'application/x-zip'],
        'dot'   => ['application/msword', 'application/vnd.ms-office'],
        'dotx'  => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword'],
        'dvi'   => ['application/x-dvi'],
        'dxr'   => ['application/x-director'],
        'eml'   => ['message/rfc822'],
        'eps'   => ['application/postscript'],
        'exe'   => ['application/octet-stream', 'application/x-msdownload'],
        'f4v'   => ['video/mp4'],
        'flac'  => ['audio/x-flac'],
        'flv'   => ['video/x-flv'],
        'gif'   => ['image/gif'],
        'gpg'   => ['application/gpg-keys'],
        'gtar'  => ['application/x-gtar'],
        'gz'    => ['application/x-gzip'],
        'gzip'  => ['application/x-gzip'],
        'heic'  => ['image/heic'],
        'heif'  => ['image/heif'],
        'hqx'   => ['application/mac-binhex40', 'application/mac-binhex', 'application/x-binhex40', 'application/x-mac-binhex40'],
        'htm'   => ['text/html', 'text/plain'],
        'html'  => ['text/html', 'text/plain'],
        'ical'  => ['text/calendar'],
        'ico'   => ['image/x-icon', 'image/x-ico', 'image/vnd.microsoft.icon'],
        'ics'   => ['text/calendar'],
        'jar'   => ['application/java-archive', 'application/x-java-application', 'application/x-jar', 'application/x-compressed'],
        'jpe'   => ['image/jpeg', 'image/pjpeg'],
        'jpeg'  => ['image/jpeg', 'image/pjpeg'],
        'jpg'   => ['image/jpeg', 'image/pjpeg'],
        'js'    => ['application/x-javascript', 'text/plain'],
        'json'  => ['application/json', 'text/json'],
        'kdb'   => ['application/octet-stream'],
        'kml'   => ['application/vnd.google-earth.kml+xml', 'application/xml', 'text/xml'],
        'kmz'   => ['application/vnd.google-earth.kmz', 'application/zip', 'application/x-zip'],
        'lha'   => ['application/octet-stream'],
        'log'   => ['text/plain', 'text/x-log'],
        'lzh'   => ['application/octet-stream'],
        'm3u'   => ['text/plain'],
        'm4a'   => ['audio/x-m4a'],
        'm4u'   => ['application/vnd.mpegurl'],
        'mid'   => ['audio/midi'],
        'midi'  => ['audio/midi'],
        'mif'   => ['application/vnd.mif'],
        'mov'   => ['video/quicktime'],
        'movie' => ['video/x-sgi-movie'],
        'mp2'   => ['audio/mpeg'],
        'mp3'   => ['audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'],
        'mp4'   => ['video/mp4'],
        'mpe'   => ['video/mpeg'],
        'mpeg'  => ['video/mpeg'],
        'mpg'   => ['video/mpeg'],
        'mpga'  => ['audio/mpeg'],
        'oda'   => ['application/oda'],
        'odp'   => ['application/vnd.oasis.opendocument.presentation'],
        'ods'   => ['application/vnd.oasis.opendocument.spreadsheet'],
        'odt'   => ['application/vnd.oasis.opendocument.text'],
        'ogg'   => ['audio/ogg'],
        'p10'   => ['application/x-pkcs10', 'application/pkcs10'],
        'p12'   => ['application/x-pkcs12'],
        'p7a'   => ['application/x-pkcs7-signature'],
        'p7c'   => ['application/pkcs7-mime', 'application/x-pkcs7-mime'],
        'p7m'   => ['application/pkcs7-mime', 'application/x-pkcs7-mime'],
        'p7r'   => ['application/x-pkcs7-certreqresp'],
        'p7s'   => ['application/pkcs7-signature'],
        'pdf'   => ['application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'],
        'pem'   => ['application/x-x509-user-cert', 'application/x-pem-file', 'application/octet-stream'],
        'pgp'   => ['application/pgp'],
        'php'   => ['application/x-httpd-php', 'application/php', 'application/x-php', 'text/php', 'text/x-php', 'application/x-httpd-php-source'],
        'php3'  => ['application/x-httpd-php'],
        'php4'  => ['application/x-httpd-php'],
        'phps'  => ['application/x-httpd-php-source'],
        'phtml' => ['application/x-httpd-php'],
        'png'   => ['image/png', 'image/x-png'],
        'ppt'   => ['application/powerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.ms-office', 'application/msword'],
        'pptx'  => ['application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/x-zip', 'application/zip'],
        'ps'    => ['application/postscript'],
        'psd'   => ['application/x-photoshop', 'image/vnd.adobe.photoshop'],
        'qt'    => ['video/quicktime'],
        'ra'    => ['audio/x-realaudio'],
        'ram'   => ['audio/x-pn-realaudio'],
        'rar'   => ['application/x-rar', 'application/rar', 'application/x-rar-compressed'],
        'rm'    => ['audio/x-pn-realaudio'],
        'rpm'   => ['audio/x-pn-realaudio-plugin'],
        'rsa'   => ['application/x-pkcs7'],
        'rtf'   => ['text/rtf'],
        'rtx'   => ['text/richtext'],
        'rv'    => ['video/vnd.rn-realvideo'],
        'sea'   => ['application/octet-stream'],
        'shtml' => ['text/html', 'text/plain'],
        'sit'   => ['application/x-stuffit'],
        'smi'   => ['application/smil'],
        'smil'  => ['application/smil'],
        'so'    => ['application/octet-stream'],
        'srt'   => ['text/srt', 'text/plain'],
        'sst'   => ['application/octet-stream'],
        'svg'   => ['image/svg+xml', 'application/xml', 'text/xml'],
        'swf'   => ['application/x-shockwave-flash'],
        'tar'   => ['application/x-tar'],
        'text'  => ['text/plain'],
        'tgz'   => ['application/x-tar', 'application/x-gzip-compressed'],
        'tif'   => ['image/tiff'],
        'tiff'  => ['image/tiff'],
        'txt'   => ['text/plain'],
        'vcf'   => ['text/x-vcard'],
        'vlc'   => ['application/videolan'],
        'vtt'   => ['text/vtt', 'text/plain'],
        'wav'   => ['audio/x-wav', 'audio/wave', 'audio/wav'],
        'wbxml' => ['application/wbxml'],
        'webm'  => ['video/webm'],
        'webp'  => ['image/webp', 'image/x-webp'],
        'wma'   => ['audio/x-ms-wma', 'video/x-ms-asf'],
        'wmlc'  => ['application/wmlc'],
        'wmv'   => ['video/x-ms-wmv', 'video/x-ms-asf'],
        'word'  => ['application/msword', 'application/octet-stream'],
        'xht'   => ['application/xhtml+xml'],
        'xhtml' => ['application/xhtml+xml'],
        'xl'    => ['application/excel'],
        'xls'   => ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword'],
        'xlsx'  => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip'],
        'xml'   => ['application/xml', 'text/xml', 'text/plain'],
        'xsl'   => ['application/xml', 'text/xsl', 'text/xml'],
        'xspf'  => ['application/xspf+xml'],
        'z'     => ['application/x-compress'],
        'zip'   => ['application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip'],
        'zsh'   => ['text/x-scriptzsh'],
    ];

    /**
     * @param array $mimes
     */
    public function __construct(array $mimes)
    {
        $this->name = 'file_type';
        $this->properties['mimes'] = self::convertMimes($mimes);
    }

    public static function convertMimes(array $mimes): array
    {
        $output = [];
        foreach ($mimes as $mime) {
            $output = array_merge($output, self::$mimes[$mime] ?? [$mime]);
        }

        $output = array_values(array_unique($output));

        return $output;
    }

    /**
     * @param array $mimes
     * @return static
     */
    public static function create(array $mimes): static
    {
        return new static($mimes);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        $mime = mime_content_type($value['tmp_name']);
        return in_array($mime, $this->properties['mimes']);
    }
}
