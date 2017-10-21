<?php

/*

Place this script in the Yii framework folder (yii-x.y.z.rxxx/yii-phar.php) and run it
to package the framework into a single phar file.

In the "index.php" of your application, assuming you placed the packaged framework under
your application's "protected" folder, add the following line at the top:

new Phar(dirname(__FILE__).'/protected/yii-1.1.9.r3527.phar');

This makes the framework available via the phar:// stream-wrapper - when specifying the
path to the Yii framework, set it as "phar://yii".

As of Yii 1.1.9.r3527, CAssetManager does not support packaging the framework this way -
I submitted the following patch, which you will need to apply, or it will not work:

http://code.google.com/p/yii/issues/detail?id=3104

*/

// Configuration:

$dir = dirname(__FILE__);

#$path = $dir.'/framework';
$paths = Array(
            $dir."/assets/hold.txt",
            $dir."/protected",
            $dir."/themes",
            $dir."/kiosk",
            $dir."/index.php",
            $dir."/phpinfo.php",
            $dir."/web.config",
            $dir."/yii/framework"
            );

$name = basename($dir).'.phar';

$mode = Phar::GZ;

// Error checks:

if (!class_exists('Phar')) {
  die('*** Phar extension is not installed (or not enabled)');
}

if (!Phar::canCompress($mode)) {
  die('*** Compression unsupported - please enable the zlib extension');
}

#if (!is_dir($path)) {
#  die('*** Yii Framework not found: '.$path);
#}

if (!Phar::canWrite()) {
  die('*** Phar is in read-only mode (check phar.readonly in php.ini)');
}

// Iterator:

class PharIterator implements Iterator, Countable {
  
  private $index;
  private $files;
  private $baselen;
  private $size;
  private $mask;
  private $dirs;
  
  public function __construct($base, $paths, $mask = '*') {
    $this->index = 0;
    $this->files = array();
    $this->baselen = strlen($base) + 1;
    $this->size = 0;
    $this->mask = $mask;
    $this->dirs = array();

    foreach($paths as $path) {
      $this->scan($path);
    }
  }

  private function scan($path)
  {
    global $phar, $baselen, $total;

    if (is_dir($path)) {
      foreach (glob($path . '/' . $this->mask) as $file) {
        if (is_dir($file)) {
          $this->dirs[$this->getRelative($file)] = $file;
          $this->scan($file);
        } else {
          $this->size += filesize($file);
          $this->files[] = $file;
        }
      }
    } else {
      $this->size += filesize(realpath($path));
      $this->files[] = realpath($path);
    }
  }
  
  private function getRelative($path) {
    return substr($path, $this->baselen);
  }
  
  public function rewind() {
    $this->index = 0;
  }

  public function current() {
    return $this->files[$this->index];
  }

  public function key() {
    return $this->getRelative($this->files[$this->index]);
  }

  public function next() {
    $this->index += 1;
  }

  public function valid() {
    return isset($this->files[$this->index]);
  }
  
  public function count() {
    return count($this->files);
  }
  
  public function getSize() {
    return $this->size;
  }
  
  public function getDirs() {
    return $this->dirs;
  }
}

// Build and Compress:

echo "Creating archive: $name\n\n";

if (file_exists($name)) {
  unlink($name);
}

try {

  $phar = new Phar($name, 0, 'vms');

  $iter = new PharIterator($dir, $paths);

  echo "Building: " . number_format(count($iter)) . ' files in ' . number_format(count($iter->getDirs())) . ' folders (' . number_format($iter->getSize()) . " bytes) ...\n\n";

  $phar->buildFromIterator($iter);

  echo "Compressing files ...\n\n";

  $phar->compressFiles($mode);

  $filesize = filesize($name);

  echo "Output: " . number_format($filesize) . " bytes (" . sprintf('%0.2f', $filesize * 100 / $iter->getSize()) . "%)\n\n";

} catch (Exception $e){
  echo $e;
}