<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Creating links to folders bitrix, local и upload</title></head>
<body>
<?
error_reporting(E_ALL & ~E_NOTICE);
@ini_set("display_errors",1);

if ($_POST['path'])
   $path = rtrim($_POST['path'],"/\\");
else
   $path = '../../dev_lota_su/public_html';

if ($_POST['create'])
{
   if (preg_match("#^/#",$path))
      $full_path = $path;
   else
      $full_path = realpath($_SERVER['DOCUMENT_ROOT'].'/'.$path);

   if (file_exists($_SERVER['DOCUMENT_ROOT']."/bitrix"))
      $strError = "The bitrix folder already exists in the current folder";
   elseif (is_dir($full_path))
   {
      if (is_dir($full_path."/bitrix"))
      {
         if (symlink($path."/bitrix",$_SERVER['DOCUMENT_ROOT']."/bitrix"))
         {
            if (symlink($path."/upload",$_SERVER['DOCUMENT_ROOT']."/upload"))
             {
               if (symlink($path."/local",$_SERVER['DOCUMENT_ROOT']."/local"))
                  echo "Symbolic links are well created";
               else
               $strError = 'Failed to create a link to the local folder, contact your server administrator';
              }
           else
           $strError = 'Failed to create a link to the upload folder, contact your server administrator';
          }
          else
          $strError = 'Failed to create a link to the bitrix folder, contact the server administrator';           
      }
      else
         $strError = 'The specified path does not contain the bitrix folder';
   }
   else
      $strError = 'Invalid path or access rights error';
   
   if ($strError)
      echo ''.$strError.'
Original path: '.$full_path;
}
?>
<form method=post>
Path to folder containing folders bitrix, local и upload: <input name=path  value="<?=htmlspecialchars($path)?>"><br>
<input type=submit value='Create' name=create>
</form>
</body> 
</html>
