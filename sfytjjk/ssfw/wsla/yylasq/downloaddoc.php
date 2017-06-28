<?php 
 /* 
  
 直接用php把word文档转化成HTML文件 
 适用于windows和安装了word的环境 
  
 */ 
  function word2html($wfilepath) 
  { 
     $word=new COM("Word.Application") or die("无法打开 MS Word"); 
 	 echo "Loading Word, v. {$word->Version}<br>"; 
     $word->visible = 1 ; 
 	  
  $word->Documents->Open('\\test.docx')or die("无法打开这个文件"); 
   
  $htmlpath=  substr($wfilepath,0,-4); 
  $word->ActiveDocument->SaveAs($htmlpath,8);  
  $word->quit(0); 

  }  

 $w="./test.docx"; 
 word2html($w); 
 print( "Word转html完成!" ); 
?>