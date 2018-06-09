<?php
namespace ZFUtils\View\Helper;

// Vendor namespaces
use Zend\View\Helper\AbstractHelper;


/**
 * FileInfo 
 * 
 * @uses   AbstractHelper
 * @author Rolando Isidoro (https://github.com/rolandoisidoro) 
 */
class FileInfo extends AbstractHelper
{
    // Fontawesome styles
    const FA_REGULAR = 'far';
    const FA_SOLID   = 'fas';


    /**
     * Match file extensions and fontawesome icons
     * @var array
     */
    private $extensionsCategories = [
        '7z'    => 'archive',
        'bmp'   => 'image',
        'doc'   => 'word',
        'docx'  => 'word',
        'gif'   => 'image',
        'gz'    => 'archive',
        'gzip'  => 'archive',
        'html'  => 'code',
        'js'    => 'code',
        'jpg'   => 'image',
        'jpeg'  => 'image',
        'mp3'   => 'audio',
        'mp4'   => 'video',
        'pdf'   => 'pdf',
        'phtml' => 'code',
        'png'   => 'image',
        'ppt'   => 'powerpoint',
        'pptx'  => 'powerpoint',
        'php'   => 'code',
        'rar'   => 'archive',
        'sql'   => 'code',
        'svg'   => 'image',
        'tar'   => 'archive',
        'tgz'   => 'archive',
        'txt'   => 'text',
        'webp'  => 'image',
        'xls'   => 'excel',
        'xlsx'  => 'excel',
        'zip'   => 'archive',
    ];

    /**
     * Fontawesome icons 
     * @var mixed
     */
    private $icons = [
        'archive'    => 'fa-file-archive',
        'audio'      => 'fa-file-audio',
        'code'       => 'fa-file-code',
        'file'       => 'fa-file',
        'excel'      => 'fa-file-excel',
        'image'      => 'fa-file-image',
        'pdf'        => 'fa-file-pdf',
        'powerpoint' => 'fa-file-powerpoint',
        'text'       => 'fa-file-alt',
        'video'      => 'fa-file-video',
        'word'       => 'fa-file-word',
    ];

    /**
     * File size measurement units 
     * @var array
     */
    private $units = [
        'B',  // Bytes
        'KB', // Kilobytes
        'MB', // Megabytes
        'GB', // Gigabytes
        'TB', // Terabytes
        'PB', // Petabytes
        'EB', // Exabytes
        'ZB', // Zettabytes
        'YB'  // Yottabytes
    ];


    /**
     * fileInfo 
     * 
     * @param  string $filePath 
     * @param  bool $absolute 
     * @access public
     * @return void
     */
    public function fileInfo(string $filePath, bool $absolute = false, string $style = 'far')
    {
        $markup = "";

        // Make sure the file path is prefixed with the DIRECTORY_SEPARATOR
        $filePath = DIRECTORY_SEPARATOR . trim($filePath, DIRECTORY_SEPARATOR);
        $filePath = $absolute ? $filePath : '.' . DIRECTORY_SEPARATOR . "public{$filePath}";

        if (file_exists($filePath)) {
            // Get file size and extension if exists
            $size      = $this->getSize($filePath);
            $extension = $this->getExtension($filePath);

            switch ($style) {
                case self::FA_SOLID:
                case self::FA_REGULAR:
                    break;

                default:
                    $style = self::FA_REGULAR;
            }

            // Assign FA icon for the given file extension
            $extensionCategory = isset($this->extensionsCategories[$extension]) ?
                                 $this->extensionsCategories[$extension] :
                                 'file';
            $icon              = "{$style} {$this->icons[$extensionCategory]}";

            // Create file info snippet
            $markup = "
                <small>
                    (
                    <span class='{$icon}'>
                        {$size}
                    </span>
                    )
                </small>
            ";
        }

        return $markup;
    }


    /**
     * getExtension 
     * 
     * @param string $filePath 
     * @access private
     * @return void
     */
    private function getExtension(string $filePath) {
        return pathinfo($filePath, PATHINFO_EXTENSION);
    }


    /**
     * getSize 
     * 
     * @param mixed $filePath 
     * @access private
     * @return void
     */
    private function getSize($filePath)
    {
        $size     = filesize($filePath);
        $exponent = $size > 0 ? floor(log($size, 1024)) : 0;

        return number_format($size / pow(1024, $exponent), 2, '.', ',') . ' ' . $this->units[$exponent];
    }


    /**
     * __invoke 
     * 
     * @param  string $filePath 
     * @param  bool $absolute 
     * @access public
     * @return void
     */
    public function __invoke(string $filePath, bool $absolute = false, $style = 'far') {
        return $this->fileInfo($filePath, $absolute, $style);
    }
}

