<?php

/**
 * Tekosher
 */
class actions{

	private $_data, $_db;

    public function __construct(){
        $this->_db = db::getInstance();
    }

	public static function Count($table, $array, $limit=null){
		$db = db::getInstance();
		return $db->get($table,$array,$limit)->count();
	}

	public function GetData($table,$array){
        $data = $this->_db->get($table, $array);
        if($data->count()) {
            $this->_data = $data->first();
            return true;
        }
        return false;
    }

    public function data(){
        return $this->_data;
    }

    public static function IndexMeta($title='',$image='https://programnas.com/control/template/media/jpg/meta_default.jpg'){
        $meta = '
        <title>Programnas '.$title.'</title>
        <meta property="og:title" content="'.$title.'">
        <meta property="og:type" content="Programnas">
        <meta name="author" content="Programnas">
        <meta property="og:image" content="'.$image.'">
        <meta property="og:description" content="Content of Programnas compromises technical questions and answers. It is a community for developer, designer and those who tend to learn from all of the technology sectors.">
        <meta name="keywords" content="IT,Website,Kurdish,Developing,Marketing System,Android,Community,Sass,Bootstrap,Social Media,OOP,Binary,Blender 3D,url,apache,twitter,instagram,facebook,Youtube,Adsense,Admob,IOS,PHP-Laravel,Cross-Platform,Xamarin,Visual Studio,Xampp,MangoDB,React JS,Flutter,Linux,Mac OS,Windows,OS,phpMyAdmin,TSL,SSL,Host,Angular JS,Server,Xcode,Android Studio,REST API,BluePrint,Unity 3D,Unreal Engine,php.ini,.htaccess,Wordpress,Wix,ASP,Gulp,Node,Node JS,YAML,XQuery,Xojo,Xeora,WebAssembly,Visual Basic,vim,Velocity,Velocity,VB.Net,Vala,TypeScript,Toolkit,UIkit,UI,Webkit,Textile,Tcl,Swift,Smarty,Smalltalk,Scheme,Scala,SAS,Rust,Ruby,Framework,Robot Framework,Regex,Reason,React TSX,React JSX,R,Qore,QML,database,Python,Pure,Puppet,Pug,Protocol Buffers,.properties,Prolog,Processing,PowerShell,PowerQuery,Mysqli,MySQL,SQL,PHPDoc,PHP,Perl,PC-Axis,Pascaligo,Pascal,OpenCL,OCaml,Objective-C,nginx,MoonScript,MATLAB,LiveScript,Lisp,Liquid,LilyPond,Less,LaTeX,Kotlin,JSON,JS Templates,JQ,Jolie,Java stack trace,JavaDoc,Java,J,Ini,Inform 7,Icon,HTTP Strict-Transport-Security,HTTP Public-Key-Pins,HTTPS,HTTP,HCL,Haskell,Handlebars,Haml,Groovy,GraphQL,Go,GameMaker Language,GLSL,Git,GEDCOM,GDScript,G-code,Fortran,Security,Firestore,Flow,Firestore security rules,Factor,F#,Excel Formula,DNS Zone,Django,Diff,DAX,Dart,D,Crystal,Clojure,CMake,CoffeeScript,CIL,C++,Concurnas,C,Bro,BrightScript,Bison,BBcode,Batch,BASIC,Shell,Bash,C#,ASP.NET,Assembly,Arduino,AQL,AppleScript,APL,ActionScript,JavaScript,MathML,SVG,XML,HTML&CSS,Library,کتێبخانە">
        <meta name="robots" content="index,follow">';
        return $meta;
    }

    public static function IndexMetaProfile($username){
        $user = new user($username);
        $meta = '
        <title>'.$user->data()->name.'</title>
        <meta property="og:title" content="'.$user->data()->name.'">
        <meta property="og:type" content="Programnas">
        <meta name="author" content="'.$user->data()->name.'">
        <meta property="og:image" content="'.$user->data()->image.'">
        <meta property="og:description" content="'.$user->data()->bio.'">
        <meta name="keywords" content="IT,Website,Kurdish,Developing,Marketing System,Android,Community,Sass,Bootstrap,Social Media,OOP,Binary,Blender 3D,url,apache,twitter,instagram,facebook,Youtube,Adsense,Admob,IOS,PHP-Laravel,Cross-Platform,Xamarin,Visual Studio,Xampp,MangoDB,React JS,Flutter,Linux,Mac OS,Windows,OS,phpMyAdmin,TSL,SSL,Host,Angular JS,Server,Xcode,Android Studio,Android,REST API,BluePrint,Unity 3D,Unreal Engine,php.ini,.htaccess,Wordpress,Wix,ASP,Gulp,Node,Node JS,YAML,XQuery,Xojo,Xeora,WebAssembly,Visual Basic,vim,Velocity,Velocity,VB.Net,Vala,TypeScript,Toolkit,UIkit,UI,Webkit,Textile,Tcl,Swift,Smarty,Smalltalk,Scheme,Scala,SAS,Rust,Ruby,Framework,Robot Framework,Regex,Reason,React TSX,React JSX,R,Qore,QML,database,Python,Pure,Puppet,Pug,Protocol Buffers,.properties,Prolog,Processing,PowerShell,PowerQuery,Mysqli,MySQL,SQL,PHPDoc,PHP,Perl,PC-Axis,Pascaligo,Pascal,OpenCL,OCaml,Objective-C,nginx,MoonScript,MATLAB,LiveScript,Lisp,Liquid,LilyPond,Less,LaTeX,Kotlin,JSON,JS Templates,JQ,Jolie,Java stack trace,JavaDoc,Java,J,Ini,Inform 7,Icon,HTTP Strict-Transport-Security,HTTP Public-Key-Pins,HTTPS,HTTP,HCL,Haskell,Handlebars,Haml,Groovy,GraphQL,Go,GameMaker Language,GLSL,Git,GEDCOM,GDScript,G-code,Fortran,Security,Firestore,Flow,Firestore security rules,Factor,F#,Excel Formula,DNS Zone,Django,Diff,DAX,Dart,D,Crystal,Clojure,CMake,CoffeeScript,CIL,C++,Concurnas,C,Bro,BrightScript,Bison,BBcode,Batch,BASIC,Shell,Bash,C#,ASP.NET,Assembly,Arduino,AQL,AppleScript,APL,ActionScript,JavaScript,MathML,SVG,XML,HTML&CSS">
        <meta name="robots" content="index,follow">';
        return $meta;
    }

    public static function IndexMetaQuestion($id){
        $questions = new questions($id);
        $title = $questions->data()->title;
        $meta = '
        <title>'.$title.'</title>
        <meta property="og:title" content="'.$title.'">
        <meta property="og:type" content="Programnas">
        <meta property="og:image" content="https://programnas.com/control/template/media/jpg/meta_default.jpg">
        <meta property="og:description" content="'.substr($questions->data()->content, 0, 50).'">
        <meta name="keywords" content="پڕۆگرامناس,IT,Website,Kurdish,Developing,Marketing System,Android,Community,Sass,Bootstrap,Social Media,OOP,Binary,Blender 3D,url,apache,twitter,instagram,facebook,Youtube,Adsense,Admob,IOS,PHP-Laravel,Cross-Platform,Xamarin,Visual Studio,Xampp,MangoDB,React JS,Flutter,Linux,Mac OS,Windows,OS,phpMyAdmin,TSL,SSL,Host,Angular JS,Server,Xcode,Android Studio,Android,REST API,BluePrint,Unity 3D,Unreal Engine,php.ini,.htaccess,Wordpress,Wix,ASP,Gulp,Node,Node JS,YAML,XQuery,Xojo,Xeora,WebAssembly,Visual Basic,vim,Velocity,Velocity,VB.Net,Vala,TypeScript,Toolkit,UIkit,UI,Webkit,Textile,Tcl,Swift,Smarty,Smalltalk,Scheme,Scala,SAS,Rust,Ruby,Framework,Robot Framework,Regex,Reason,React TSX,React JSX,R,Qore,QML,database,Python,Pure,Puppet,Pug,Protocol Buffers,.properties,Prolog,Processing,PowerShell,PowerQuery,Mysqli,MySQL,SQL,PHPDoc,PHP,Perl,PC-Axis,Pascaligo,Pascal,OpenCL,OCaml,Objective-C,nginx,MoonScript,MATLAB,LiveScript,Lisp,Liquid,LilyPond,Less,LaTeX,Kotlin,JSON,JS Templates,JQ,Jolie,Java stack trace,JavaDoc,Java,J,Ini,Inform 7,Icon,HTTP Strict-Transport-Security,HTTP Public-Key-Pins,HTTPS,HTTP,HCL,Haskell,Handlebars,Haml,Groovy,GraphQL,Go,GameMaker Language,GLSL,Git,GEDCOM,GDScript,G-code,Fortran,Security,Firestore,Flow,Firestore security rules,Factor,F#,Excel Formula,DNS Zone,Django,Diff,DAX,Dart,D,Crystal,Clojure,CMake,CoffeeScript,CIL,C++,Concurnas,C,Bro,BrightScript,Bison,BBcode,Batch,BASIC,Shell,Bash,C#,ASP.NET,Assembly,Arduino,AQL,AppleScript,APL,ActionScript,JavaScript,MathML,SVG,XML,HTML&CSS,'.$title.','.KurdishToLatin($title).'">
        <meta name="robots" content="index,follow">';
        return $meta;
    }

    public static function IndexMetaLibrary($title='',$image='https://programnas.com/control/template/media/jpg/meta_default_library.jpg'){
        $meta = '
        <title>Programnas '.$title.'</title>
        <meta property="og:title" content="'.$title.'">
        <meta property="og:type" content="Programnas Library">
        <meta name="author" content="Programnas Library">
        <meta property="og:image" content="'.$image.'">
        <meta property="og:description" content="Programnas Library is a collection of books from other websites and blogs. you can read and download books for free.کتێبخانەی پڕۆگرامناس کۆکراوەی دەزگا و ماڵپەڕەکانی ترن. دەتوانیت کتێبەکان بە خۆڕایی بخوێنیتەوە و دایانبگریت.">
        <meta name="keywords" content="Programnas,Library,books,Kteb,Pertwk,Ktebxana,Author,پڕۆگرامناس,کتێبخانە,کتێب,پەرتوک،نوسەر">
        <meta name="robots" content="index,follow">';
        return $meta;
    }

    public static function MetaLibrary($title, $image){
        $meta = '
        <title>'.$title.'</title>
        <meta property="og:title" content="'.$title.'">
        <meta property="og:type" content="Programnas Library">
        <meta property="og:image" content="'.$image.'">
        <meta property="og:description" content="'.$title.'">
        <meta name="keywords" content="Programnas,Library,books,Kteb,Pertwk,Ktebxana,Author,پڕۆگرامناس,کتێبخانە,کتێب,پەرتوک،نوسەر">
        <meta name="robots" content="index,follow">';
        return $meta;
    }

    public static function Relative($top,$bottom=null,$left=null,$right=null){
        $s = 'style="position:relative;';
        if ($top != null) {
            $s .= 'top:'.$top.'px;';
        }if ($bottom != null) {
            $s .= 'bottom:'.$bottom.'px;';
        }if ($left != null) {
            $s .= 'left:'.$left.'px;';
        }if ($right != null) {
            $s .= 'right:'.$right.'px;';
        }
        return $s.'"';
    }

    public static function Absolute($top,$bottom=null,$left=null,$right=null){
        $s = 'style="position:absolute;';
        if ($top != null) {
            $s .= 'top:'.$top.'px;';
        }if ($bottom != null) {
            $s .= 'bottom:'.$bottom.'px;';
        }if ($left != null) {
            $s .= 'left:'.$left.'px;';
        }if ($right != null) {
            $s .= 'right:'.$right.'px;';
        }
        return $s.'"';
    }

    public static function EscapeSql($join,$value){
        return $join->real_escape_string($value);
    }

    public static function SVG($img,$size,$position='unset',$addetional=null){
        return 'style="background-image:url('.$img.');width:'.$size.'px;height:'.$size.'px;background-size:'.$size.'px;display:inline-block;background-position:'.$position.';'.$addetional.'"';
    }

    public static function Toast($message){
        return '<div id="snackbar">'.$message.'</div>';
    }

    public static function ProgressBar($id,$circlar=false,$display='_None'){
        if (!$circlar) {
            return '<span align="center" class="'.$display.'" id="'.$id.'"><span class="_LOaDgif"></span></span>';
        }else{
            return '<span align="center" class="'.$display.'" id="'.$id.'"><span class="_LOaDgifCir"></span></span>';
        }
        
    }

    public static function Code($lang,$box_id,$text){
        $code = strip_tags(filter_var($text, FILTER_SANITIZE_STRING));
        $count = substr_count($code, "\n") + 2;
        $lines = '';
        for ($i=1; $i < $count; $i++) { 
            $lines .= "<span class='__CodingFont span_line_'>".$i."</span>\n";
        }
        return '
        <div style="margin: 6px 6px -4px 6px;">
            <span class="justLamng_">'.ucfirst($lang).'</span>
            <button class="box_copy_butt" onclick="CopyCodeBox('.$box_id.', this)">'._COPY_IT.'</button>
        </div>
        <pre class="_pre_code" style="margin: 6px;height: auto;max-width: 645px;">
            <div class="_mainLines">
                <div class="_botCline">'.$lines.'</div>
            </div>
            <code id="code_'.$box_id.'" class="language-'.$lang.' __CodingFont" style="position: relative;left: 30px;">'.$code.'</code>
        </pre>';
    }

    public static function ContentText($text, $margin=0){
        $data = '<div dir="auto" style="margin: '.$margin.';overflow-x: auto;">';
        $text = strip_tags(filter_var($text, FILTER_SANITIZE_STRING));
        $data .= $text;
        $data .= '</div>';
        return $data;
    }

    public static function RandColors(){
        $colors = array(
            0 => '9acd32', 1 => '001946d4',2 => '2baebf',3 => 'e2a929',4 => 'ad2020',5 => 'ad2095',6 => '5d20ad',7 => '2073ad',8 => '20a7ad',9 => '49ad20',10 => 'ad8220',11 => '000000',12 => 'ad2095',13 => '607D8B',14 => '6b0651',15 => '8a8a8a',16 => '337b71',17 => 'ff6464',18 => 'e0ff64',19 => 'ff64f3',20 => 'b38787',21 => '611919',22 => '1c5619');
        return '#' . $colors[rand(11,22)];
    }

    public function GetBanner($size,$ad_id='ad_s'){
        $data = '';
        $count_ads = $this->_db->get('ads',array('id','>',0))->count();
        $rand = rand(1,$count_ads);
        $this->GetData('ads',array('ad_num','=',$rand));
        $d = $this->data();
        $data .= '<a id="'.$ad_id.'" data-size="'.$size.'" target="_blank" href="'.$d->link.'" class="a_image_ads'.$size.'" style="background-image: url(/control/template/media/jpg/ads/'.$d->image.'_'.$size.'.jpg);"></a>';
        return $data;
    }

}

?>