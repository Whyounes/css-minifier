Simple css minifier based on [GarryJones](https://github.com/GaryJones/Simple-PHP-CSS-Minification/) css minifer.

##Installation

In your `composer.json` file, require `rafie/Cssminifier` and run `composer dumpautoload`.

After the download has finished, in your `app/config/app.php` you need to:

- Add `Rafie\Cssminifier\CssminifierServiceProvider` to the `providers` array.
- Add `'CssMin' => 'Rafie\Cssminifier\Facades\CssMin'` to the `aliases` array. ( only if you want to use the static interface `CssMin::minify(...)` )

##Usage

```
//through the Ioc

$cssmin = App::make("cssmin");

$cssmin->minify(
  [
    'path/to/file1.css',
    'path/to/file2.css'
  ],
  'output/path',
  true,// (optional) remove comments or no
  false // (optional) concat the resulted files into one file 'all.min.css'
);

//Through the Facade

```
CssMin::minify(
  [
    'path/to/file1.css',
    'path/to/file2.css'
  ],
  'output/path',
  true,// (optional) remove comments or no
  false // (optional) concat the resulted files into one file 'all.min.css'
);

```
##TODO
write tests
