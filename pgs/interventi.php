<?php 
	$msg='';
	$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
	$intervento=(empty($_REQUEST['id'])) ?  R::dispense('interventi') : R::load('interventi', intval($_REQUEST['id']));
	if (!empty($_REQUEST['descrizione'])) : 
		$intervento->descrizione=$_POST['descrizione'];
		$intervento->pc_id=$_POST['pc_id'];
		$intervento->spesa=floatval($_POST['spesa']);
		$intervento->ore=intval($_POST['ore']);
		$intervento->dataintervento=date_create($_POST['dataintervento']);
		try {
			R::store($intervento);
			$msg='Dati salvati correttamente ('.json_encode($intervento).') ';
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	
	if (!empty($_REQUEST['del'])) : 
		$intervento=R::load('interventi', intval($_REQUEST['del']));
		try{
			R::trash($intervento);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;
	
	$interventi=R::findAll('interventi', 'ORDER by id ASC LIMIT 999');
	$pc=R::findAll('pc');
	$new=!empty($_REQUEST['create']);
	
?>

<h1>
	<a href="index.php">
		<?=($id) ? ($new) ? 'Nuovo intervento' : 'Intervento n. '.$id : 'Interventi';?>
	</a>
</h1>
<?php if ($id || $new) : ?>
		<form method="post" action="?p=interventi">
			<?php if ($id) : ?>
				<input type="hidden" name="id" value="<?=$intervento->id?>" />
			<?php endif; ?>
			<label for="descrizione">
				Descrizione
			</label>
			<input name="descrizione"  value="<?=$intervento->descrizione?>" autofocus required  />

			<label for="dataintervento">
				Data
			</label>
			<input name="dataintervento"  value="<?=date('Y-m-d',strtotime($intervento->dataintervento))?>" type="date" />
			
			<label for="pc_id">
				PC
			</label>
			<select name="pc_id">
				<option />
				<?php foreach ($pc as $a) : ?>
					<option value="<?=$a->id?>" <?=($a->id==$id) ? 'selected' :'' ?> >
						<?=$a->sn?>
					</option>
				<?php endforeach; ?>
			</select>
			<label for="ore">
				ore
			</label>			
			<input name="ore"  value="<?=$intervento->ore?>" type="number" />

			<label for="dataintervento">
				Spesa
			</label>			
			<input name="spesa"  value="<?=$intervento->spesa?>" type="number" step="any" />			
			
			<button type="submit" tabindex="-1">
				Salva
			</button>
			
			<a href="?p=interventi" >
				Elenco
			</a>			
			
			<a href="?p=interventi&del=<?=$ma['id']?>" tabindex="-1">
				Elimina
			</a>					
		</form>
<?php else : ?>
	<div class="tablecontainer">
		<table style="table-layout:fixed">
			<colgroup>
				<col style="width:150px" />
			</colgroup>
			<thead>
				<tr>
					<th>PC</th>
					<th>Data e ora</th>
					<th>Descrizione</th>
					<th>ore</th>
					<th>Spesa</th>
					<th style="width:60px;text-align:center">Modifica</th>
					<th style="width:60px;text-align:center">Cancella</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($interventi as $r) : ?>
				<tr>
					<td>
							<?=($r->pc_id) ? $r->pc->sn : ''?>
					</td>			
					<td>
						<?=date('d/m/Y',strtotime($r->dataintervento))?>
					</td>
					<td>
						<?=$r->descrizione?>
					</td>
					<td style="text-align:right" >
						<?=$r->ore?>
					</td>	
					<td style="text-align:right" >
						<?=$r->spesa?>
					</td>				
					<td style="text-align:center" >
						<a href="?p=interventi&id=<?=$r['id']?>">
							Mod.
						</a>
					</td>
					<td style="text-align:center" >
						<a href="?p=interventi&del=<?=$r['id']?>" tabindex="-1">
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
<a href="?p=interventi&create=1">Inserisci nuovo</a>
<script>
	var chg=function(e){
		console.log(e.name,e.value)
		document.forms.frm.elements[e.name].value=(e.value) ? e.value : null
	}	
</script>