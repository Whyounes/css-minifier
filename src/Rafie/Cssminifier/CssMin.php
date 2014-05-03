<?php 

namespace Rafie\Cssminifier;



class CssMin {

    /**
    *   Remove comments or no
    *   
    *   @var bool
    */
    protected $no_comments;

    /**
    *   Concat minified files
    *
    *   @var bool
    */
    protected $concat;

    /**
    *   Array of files paths
    *
    *   @var array
    */
    protected $files;

    /**
    *   Ouptput directory
    *   
    *   @var string
    */
    protected $output_dir;


    public function __construct(){
    }

    /**
    *   Run the minification
    *   
    *   @param array   $file            array of paths to css files
    *   @param string  $output_dir      path to the output directory
    *   @param bool    $no_comments     Remove comments or no
    *   @param bool    $concat          concat the result to one file
    *
    *   @return void
    */

    public function minify( array $files, $output_dir , $no_comments = true, $concat = false ){
        $this->files = $files;
        $this->output_dir = $output_dir;
        $this->no_comments = $no_comments;
        $this->concat = $concat;

        $this->processFiles();
    }

    /**
    *   Process the files array
    *   
    *   @param string   $css CSS        source code
    *   @param bool     $no_comments    Leave comments or no
    *   
    *   @return string minified CSS source code
    */

    private function processFiles(){
        $css_result = [];

        foreach ( $this->files as $file ) {
            //read file content
            $file_content = $this->get_file_content( $file );
            //minify CSS and add it to the result array
            $css_result[] = $this->css_min( $file_content, $this->no_comments );
        }//foreach

        if( $this->concat ){
            $css_concat = $this->concat( $css_result );
            $this->save_file_content($this->output_dir . '/all.min.css', $css_concat);
        }//if
        else{
            foreach ($css_result as $key => $css) {
                //remove '.css' to add '.min.css'
                $filename = basename( $this->files[$key], '.css' ) . '.min.css';
                
                $this->save_file_content($this->output_dir . '/' . $filename, $css);
            }//for
        }//else

    }//processFiles

    /**
    *   Minify the resulted css
    *   
    *   @param string   $css CSS source code
    *   @param bool     $no_comments Leave comments or no
    *   
    *   @return string minified CSS source code
    */

    public function css_min( $css, $no_comments ){
        // Normalize whitespace
        $css = preg_replace( '/\s+/', ' ', $css );

        // Remove comment blocks, everything between /* and */, unless
        // preserved with /*! ... */
        if( $no_comments ){
            $css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );
        }//if
        
        // Remove ; before }
        $css = preg_replace( '/;(?=\s*})/', '', $css );

        // Remove space after , : ; { } */ >
        $css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

        // Remove space before , ; { } ( ) >
        $css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

        // Strips leading 0 on decimal values (converts 0.5px into .5px)
        $css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

        // Strips units if value is 0 (converts 0px to 0)
        $css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

        // Converts all zeros value into short-hand
        $css = preg_replace( '/0 0 0 0/', '0', $css );

        // Shortern 6-character hex color codes to 3-character where possible
        $css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

        return trim( $css );
    
    }//minify

    /**
    *   Read the content of a file
    *   
    *   @param string $filename path to css file
    *   
    *   @return string file content
    */

    private function get_file_content( $filename ){
        //test if exist
        $css = file_get_contents( $filename );

        return $css;
    }

    /**
    *   Save the content of a file
    *   
    *   @param string $filename path to css file
    *   @param string $content  Content to be saved
    *   
    */

    private function save_file_content( $filename, $content ){
        //test if exist
        $res = file_put_contents( $filename, $content );

        return $res;
    }

    /**
    *   Concat the minified files and result a single string
    *   
    *   @param array $strings list of minified files
    *   
    *   @return string concatenated string
    */

    private function concat( array $strings ){
        return implode( PHP_EOL, $strings );
    }


}

//$cssmin = new CssMin( [ 'public/style.css', 'public/responsive.css' ], 'public/min_css', false, true );