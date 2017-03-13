<?php 
	$msg='';
	$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
	$intervento=(empty($_REQUEST['id'])) ?  R::dispense('pc') : R::load('pc', intval($_REQUEST['id']));
	if (!empty($_REQUEST['hostname'])) : 
		$intervento->hostname=$_POST['hostname'];
		$intervento->marche_id=$_POST['marche_id'];
		$intervento->modello=($_POST['modello']);
		$intervento->sn=($_POST['sn']);
		
		try {
			R::store($intervento);
			//$msg='Dati salvati correttamente ('.json_encode($intervento).') ';
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	
	if (!empty($_REQUEST['del'])) : 
		$intervento=R::load('pc', intval($_REQUEST['del']));
		try{
			R::trash($intervento);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;
	
	$interventi=R::findAll('pc', 'ORDER by id ASC LIMIT 999');
	$pc=R::findAll('marche');
	$new=!empty($_REQUEST['create']);
	$coll=R::findAll('interventi', 'ORDER by id ASC LIMIT 999');
?>

<h1>
	<a href="index.php">
		<?=($id) ? ($new) ? 'Nuovo PC' : 'PC n. '.$id : 'PC';?>
	</a>
</h1>
<?php if ($id || $new) : ?>


		<form method="post" action="?p=pc">
			<?php if ($id) : ?>
				<input type="hidden" name="id" value="<?=$intervento->id?>" />
			<?php endif; ?>
			<label for="marche_id">
				Marche
			</label>
			<select name="marche_id">
				<option />
				<?php foreach ($pc as $a) : ?>
					<option value="<?=$a->id?>" <?=($a->id==$id) ? 'selected' :'' ?> >
						<?=$a->marca?>
					</option>
				<?php endforeach; ?>
			</select>
			<label for="hostname">
				Cliente
			</label>
			<input name="hostname"  value="<?=$intervento->hostname?>" autofocus required  />
			<label for="modello">
				Modello
			</label>
			<input name="modello"  value="<?=$intervento->modello?>"/>
			
			<label for="sn">
				Seriale
			</label>			
			<input name="sn"  value="<?=$intervento->sn?>"  />			
			
			<button type="submit" tabindex="-1">
				Salva
			</button>
			
			<a href="?p=pc" >
				Elenco
			</a>			
			
			<a href="?p=interventi&del=<?=$ma['id']?>" tabindex="-1">
				Elimina
			</a>					
		</form>
<?php else : ?>
	<div class="tablecontainer">
		<table class="table responsive table-bordered table-striped" style="table-layout:fixed">
			<colgroup>
				<col style="width:150px" />
			</colgroup>
			<thead>
				<tr>
					<th>Marche</th>
					<th>Cliente</th>
					<th>Modello</th>
					<th>Seriale</th>
					
					<th style="width:100px;text-align:center">Modifica</th>
					<th style="width:100px;text-align:center">Cancella</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($coll as $g) : ?>
					<tr>			       
				   <td>
                            <?= $g->descrizione ?>
                    </td>
					</tr>
					<?php endforeach; ?>
			<?php foreach ($interventi as $r) : ?>
				<tr>
					<td>
							<?=($r->marche_id) ? $r->marche->marca : ''?>
					</td>			
					
					<td>
						<?=$r->hostname ?>
					</td>
					<td style="text-align:right" >
						<?=$r->modello?>
					</td>	
					<td style="text-align:right" >
						<?=$r->sn?>
					</td>
					<td>
                            <?= ($r->pc_id) ? $r->interventi->descrizione : '' ?>
                    </td>
					<td style="text-align:center" >
						<a href="?p=pc&id=<?=$r['id']?>">
							Mod.
						</a>
					</td>
					<td style="text-align:center" >
						<a href="?p=pc&del=<?=$r['id']?>" tabindex="-1">
							x
						</a>
					</td>							
				</tr>		
			<?php endforeach; ?>
			</tbody>
		</table>
		<h4 class="msg">
			<?=$msg?>
		</h4>	
	</div>
<?php endif; ?>
<a href="?p=pc&create=1">Inserisci nuovo</a>
<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script>
	var chg=function(e){
		console.log(e.name,e.value)
		document.forms.frm.elements[e.name].value=(e.value) ? e.value : null
	}	
</script>