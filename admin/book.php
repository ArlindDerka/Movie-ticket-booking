<style>
	td img{
		width: 50px;
		height: 75px;
		margin:auto;
	}
	td p {
		margin: 0
	}
</style>
<?php include ('db_connect.php') ?>
<div class="container-fluid">
	<div class="row">
		<div class="card col-md-12 mt-3"> 
			<div class="card-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Emri</th>
							<th class="text-center">Kontakti #</th>
							<th class="text-center">Shfaqja</th>
							<th class="text-center">Info Rezervimi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$movie = $conn->query("SELECT b.*,m.title,ts.seat_group,t.name as theater FROM books b inner join movies m on b.movie_id = m.id inner join theater_settings ts on ts.id = b.ts_id inner join theater t on t.id = ts.theater_id  ");
						while($row=$movie->fetch_assoc()){
						 ?>
						 <tr>
						 	<td><?php echo $i++ ?></td>
						 	<td><?php echo ucwords($row['lastname'].', '.$row['firstname']) ?></td>
						 	<td><?php echo $row['contact_no'] ?></td>
						 	<td><?php echo $row['title'] ?></td>
						 	<td>
						 		<p><small><b>Teatri:</b> <?php echo $row['theater'] ?></small></p>
						 		<p><small><b>Grupi Vendeve:</b> <?php echo $row['seat_group'] ?></small></p>
						 		<p><small><b>Sasia:</b> <?php echo $row['qty'] ?></small></p>
						 		<p><small><b>Data:</b> <?php echo date("M d,Y",strtotime($row['date'])) ?></small></p>
						 		<p><small><b>Ora:</b> <?php echo date("h:i A",strtotime($row['time'])) ?></small></p>
						 	</td>
						 	
						 	
						 </tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<script>
	$('table').dataTable();
	$('#new_movie').click(function(){
		uni_modal('New Movie','manage_movie.php');
	})
	$('.edit_movie').click(function(){
		uni_modal('Edit Movie','manage_movie.php?id='+$(this).attr('data-id'));
	})
	$('.delete_movie').click(function(){
		_conf('Jeni i sigurt qe doni ta fshini?','delete_movie' , [$(this).attr('data-id')])
	})

	function delete_movie($id=''){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_movie',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp ==1){
					alert_toast("Te dhenat u fshine me sukses!",'success');
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	}
</script>