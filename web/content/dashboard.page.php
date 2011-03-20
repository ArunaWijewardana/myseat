
<!-- Begin one column box -->
<div class='onecolumn'>
 <div class='header'>
	<a href="?selectedDate=<?= buildDate($settings['dbdate'],$sd,$sm,$sj,-1); ?>" class="navgroup">
		&laquo;
	</a>
	<div class="date dategroup">
		<div class="text" id="datetext"><?= $_SESSION['selectedDate_user']; ?></div>
		<input type="text" id="datepicker"/>
		<input type="hidden" id="dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
	</div>
	<a href="?selectedDate=<?= buildDate($settings['dbdate'],$sd,$sm,$sj,1); ?>" class="navgroup">
		&raquo;
	</a>
	<!-- Begin 2nd level tab -->
	<ul class='second_level_tab'>
		<li>
			<a href='?p=2' class='button_dark'> <?= _back;?>
			</a>
		<li/>
	</ul>
	<!-- End 2nd level tab -->
 </div>
<div id='content_wrapper'>
		<? 
			// MESSAGE boxes goes here
			include('includes/messagebox.inc.php'); 
		?>
</div>
</div>
<br class='cl' />
			<?
			// memorize actual selected outlet
			$rem_outlet = $_SESSION['outletID'];
			
			$outlets = querySQL('db_outlets');
			foreach($outlets as $row) {
			 if ( ($row->saison_start<=$row->saison_end 
				 && $_SESSION['selectedDate_saison']>=$row->saison_start 
				 && $_SESSION['selectedDate_saison']<=$row->saison_end)
				){
					// outlet ID
					$_SESSION['outletID'] = $row->outlet_id;
					// outlet settings
					$rows = querySQL('db_outlet_info');
					if($rows){
						foreach ($rows as $key => $value) {
							$_SESSION['selOutlet'][$key] = $value;
						}
					}
					echo"<div class='onecolumn'><div class='header'>\n";
					echo"<div class='dategroup_name'>
						<a href='main_page.php?p=2&outletID=".$row->outlet_id."'>".$row->outlet_name."</a></div>
					</div>\n
					<div id='content_wrapper'>\n";

					//make each outlet a timeline
					include('includes/timeline.inc.php');
					echo"<br class='cl' /><br/>\n</div></div><br/>";
				}
			}
			// memorize actual selected outlet
			$_SESSION['outletID'] = $rem_outlet;
			// memorize selected outlet details
			$rows = querySQL('db_outlet_info');
			if($rows){
				foreach ($rows as $key => $value) {
					$_SESSION['selOutlet'][$key] = $value;
				}
			}
			?>

<br class="clear"/><br/>