
	<!-- Begin 1st level tab -->
	<ul class="first_level_tab">
		<li>
			<a href="main_page.php?q=1" <? if ($q == 1 || $q == 4) { echo " class='active'";}?> >
				<?= _confirmed_reservations; ?>
			</a>
		</li>
		<?php 
		if ( $today_date <= $_SESSION['selectedDate'] && $dayoff == 0 && current_user_can('Reservation-New') ){
			echo'<li>
				<a href="main_page.php?q=2"';
				if ($q == 2) { echo " class='active'";}
				echo' >'._add_reservation.'</a></li>';
		} 
		?>
		<li>
			<a href="main_page.php?q=3&s=1" <? if ($q == 3) { echo " class='active'";}?> >
				<?= _canceled_reservations; ?>
			</a>
		</li>
	</ul>	
	<!-- End 1st level tab -->
	
	<br class="clear"/>
	
	<!-- Begin one column box -->
	<div class="onecolumn">
		
		<div class="header">
			
			<? if ($searchquery == ''){ ?>
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
			<div class="dategroup_name">
				<a href="?selectedDate=<?= buildDate($settings['dbdate']); ?>">
					<?= querySQL('db_outlet'); ?>
				</a>
			</div>
			
			<!-- Begin 2nd level tab -->
			<ul class="second_level_tab noprint">
				<li>
					<a href="#" id="outlet_detail_button">
						<?= _detail;?>
					</a>
				</li>
				<? if ($q == 1){ ?>
				<li>
					<a href="javascript:window.print()">
						<!-- <img src="images/menu-icons/printer.png" alt="Print"> -->
						<?= _print;?>
					</a>
				</li>
				<? } ?>
			</ul>
			<!-- End 2nd level tab -->
			<? }else{ ?>
			<div class="dategroup_name">
				<?= _search_results;?>
			</div>
			<!-- Begin 2nd level tab -->
			<ul class="second_level_tab">
				<li>
					<a href="main_page.php?q=1" id="search_back_button">
						<?= _back;?>
					</a>
				</li>
			</ul>
			<!-- End 2nd level tab -->
			<? } ?>
		</div>

		<!-- Daily outlets details -->
		<div id='daily_outlets_details'>
			<? include('includes/daily_outlet_details.inc.php'); ?>
		</div>		

		<!-- ALERT & MESSAGE boxes goes here -->
			<? 
			if($searchquery == '' && $_SESSION['storno'] == 0){ 
				include('includes/messagebox.inc.php'); 
			} 
			$_SESSION['errors'] = array();
			$_SESSION['messages'] = array();
			?>

		<!-- CAPACITY timeline goes here -->
		<?

		if(($q=='1' || $q=='2') && $dayoff == 0){
		echo "<div class='timeline-section' id='timeline'>";	
			include('includes/timeline.inc.php');
		echo "</div><br class='clear'/>";	
		}
		?>
		
		<!-- Begin nomargin -->
		<div class="content nomargin">
			
			<?
			// ** content
			switch($q){
				case '1':
				 if($dayoff == 0){	
					// confirmed
					include('includes/reservations_grid.inc.php');
		
					// waitlist
					$_SESSION['wait'] = 1;
					$waitlist =	querySQL('reservations');
					if($waitlist){
						echo "<br/><h3>"._wait_list."</h3><br/><br/>";
						include('includes/reservations_grid.inc.php');
					}
				 }else{
					echo "<h2 style='margin-left:45%;margin-top:50px;'>"._day_off."</h2>";
				 }
				break;
				case '2':
					// new
					include('includes/new.inc.php');
				break;
				case '3':
					// cancelled/storno
					include('includes/reservations_grid.inc.php');
				break;
				case '4':
					// search
					include('includes/search_grid.inc.php');
				break;
			}
			echo"<br/>";
			include('includes/manual_lines.inc.php');
			//most recent reservations
			include('includes/recent.inc.php');
			?>
			<br/>
			<br class="clear"/>
		</div>
		<!-- End nomargin -->
</div>
<br class="clear"/>