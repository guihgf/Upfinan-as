
<?php
    if(!empty($_SESSION["total_registros"]))
    {?>
		<div class="dataTables_info" id="table2_info"><?php echo $_SESSION["total_registros"]?> registro(s) encontrado(s) -Página <?php if(!empty($_GET["pag"])){echo $_GET["pag"];}else{ echo 1;} ?> de <?php echo  $_SESSION["total_paginas"]?></div>
   <?php
    }
	else
	{?>
		<div class="dataTables_info" id="table2_info">Não foram encontrados registros para a sua busca.</div>
	<?php
	}?>

	<div class="dataTables_paginate paging_full_numbers" id="table2_paginate">
		<?php
		    $i=0;
			$class="";
		    while($i<>$_SESSION["total_paginas"]){?>
				<?php
				    $i++;
					$class="paginate_button";
					if(!empty($_GET["pag"]))
					{
						if ($i==(int)$_GET["pag"]){
							$class="paginate_active";						
						}
					}
					else //esta na primeira pagina
					{
						if ($i==1){
							$class="paginate_active";
						}
					}
				    if(!empty($_GET["pag"]))
				    {
				        echo '<a class="'.$class.'" href='.substr("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",0,stripos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "pag"))."pag=".$i.'>'.$i.'</a> ';
				    }
				    else if(!empty ($_GET["opcao"]))
				    {
				        echo '<a class="'.$class.'" href='."http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."&pag=".$i.'>'.$i.'</a> ';
				    }
				    else
				    {
				        echo '<a class="'.$class.'"  href='."http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."?pag=".$i.'>'.$i.'</a>';
				    }?>
	    <?php    
	    }
	    ?>
	</div>
    
