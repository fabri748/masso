<?php 
	if (!empty($_REQUEST['del'])) : 
		$marca=R::load('marche', intval($_REQUEST['del']));
		try{
			R::trash($marca);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	if (!empty($_POST['marca'])) : 
		if (empty($_POST['id'])){
			$marca=R::dispense('marche');
		}else{
			$marca=R::load('marche',intval($_POST['id']));
		}
		$marca->marca=$_POST['marca'];

		try {
			$id=R::store($marca);
		} catch (RedBeanPHP\RedException\SQL $e) {
			?>
			<h4 class="msg label error">
				<?=$e->getMessage()?>
			</h4>
			<?
		}	
	endif;
	
	$marche=R::findAll('marche');
?>
<h1>
	<a href="index.php">
		Marche
	</a>
	
</h1>
<section class="">
	<?php foreach ($marche as $ma) : ?>
		<article class="">
			<form method="post" action="?p=marche">
				<input name="marca"  value="<?=$ma->marca?>"  />
				<input type="hidden" name="id" value="<?=$ma->id?>" />
				<button type="submit" tabindex="-1">
					Salva
				</button>
				<a href="?p=marche&del=<?=$ma['id']?>" class="button dangerous" tabindex="-1">
					Elimina
				</a>					
			</form>
		</article>
	<?php endforeach; ?>
		<article class="card cc">
			<form method="post" action="?p=marche">
				<input name="marca" placeholder="Nuova marca" autofocus />
				<button type="submit">
					Inserisci
				</button>
			</form>
		</article>
</section>