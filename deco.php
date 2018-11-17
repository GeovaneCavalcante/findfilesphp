<?php $px = 0; ?>
<?php

function main(){
    $types = array( 'php', 'html');
    $path = './edoc';
    $dir = new DirectoryIterator($path);

    foreach ($dir as $fileInfo) {
        
        $subpath = './edoc/'. $fileInfo;

        if($fileInfo == '..' || $fileInfo == '.'){

        }else{
            if(is_dir($subpath)){
                sub($subpath);
            }
        }
        $ext = strtolower( $fileInfo->getExtension() );
        if( in_array( $ext, $types ) ) {
            echo "<p style='margin-left: 0px;'>" .$subpath. '</p>';
        }
    }

}

function sub($pat, $px = 0){

    $types = array( 'php', 'html');
 
    //echo  "<p style='margin-left: ".$px."px;'>" . $pat . '</p>';
    
    $dir = new DirectoryIterator($pat);
    foreach ($dir as $fileInfo) {
        $subpath = $fileInfo;
        if($subpath == '..' || $subpath == '.'){

        }else{
            if(is_dir($pat. '/'.$subpath)){
                //echo  "<p style='margin-left: ".$px."px;'>" . $pat. '/'.$subpath . '</p>';
                sub($pat. '/'.$subpath, $px + 20);
            }
        }
        $ext = strtolower( $fileInfo->getExtension() );
        if( in_array( $ext, $types ) ){
            $pathFile  = $pat. '/'. $fileInfo->getFilename();
            $pathDest  = $pat .'/';
            //echo "<p style='margin-left: ".$px."px;'>" .$pat. '/'. $fileInfo->getFilename() . '</p>';
            //echo "<p style='margin-left: ".$px."px;'>" .  $pathDest .'</p>';
            $NameFile  = $fileInfo->getFilename();
            decode($pathFile, $pathDest, $NameFile);
        } 
    }
}

function decode($pathFile, $pathDest, $NameFile){
    
    echo "<p>" . $pathFile . '</p>';
    echo "<p>" .  $pathDest .'</p>';
    echo "<p>" .  $NameFile .'</p>';

    $NewName = explode('.', $NameFile);
    $NewName = join('.', $NewName);
    echo "<p>" .  $NewName .'</p>';

    $path = $pathFile;

    $dest = $pathDest . $NewName;

    echo "<p>" .  $path .'</p>';
    echo "<p>" .  $dest .'</p>';

    $diretorio = dir($path);

    $conteudo = file_get_contents($path);
    $dado = [];

    preg_match('/\".*\"/', $conteudo, $dado);
 
    $decodificado = gzinflate(base64_decode(substr($dado[0], 1, -1)));
    
    if($decodificado != ""){
        $conteudo = "<?php\n" . $decodificado .  " ?>";
    }
  
    $arquivo = fopen($dest, 'w');
    fwrite($arquivo, $conteudo);
    fclose($arquivo);

}

main();
?>
