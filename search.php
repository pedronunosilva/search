<!DOCTYPE html>

<html>

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="kube.min.css" />
    
	<title>Search</title>

</head>

<body class="units-container">
	
	<div class="units-row units-padding">
		
	<div class="unit-centered unit-60">
		
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="forms">
			
			<label class="input-groups">
				
				<input type="text" name="search" placeholder="Search" />
				
				<span class="btn-append">
            
					<button class="btn" type="submit">Search</button>
				
				</span>
			</label>
		
		</form>
		
        <hr >
        
		<?php 
			
		
		if( isset($_POST['search']) 
			&& !empty($_POST['search']) 
			&& preg_match("/^[a-zA-Z]/" , $name = trim($_POST['search']))
			&& strlen($name) >= 3 ) {
				
			
				
			echo 'you type <b>"' . $name . '"</b> <br /><br /><hr >';
							
				
			try
	
			{
    
				$conn = new PDO( 'sqlite:search.sqlite' );
				
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
												
				$split = explode( " ", $name );
				
				$sql = "SELECT DISTINCT name FROM names
						WHERE ( ";
						
				foreach( $split as $val ) {
					
					if( $val <> " " && strlen($val) > 2 ) {
												
						$sql .= "( name LIKE '$val%'
							OR name LIKE '%$val'  
							OR name LIKE '%$val%') AND ";
													
					}
					
				}
				
					
				$sql=substr($sql,0,(strLen($sql)-4));//this will eat the last AND
				
				$sql .= " )";
				
				//echo $sql;
		
				$stmt = $conn->prepare($sql);
				
				$stmt->execute();
   		
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				
				echo '<b>Results: </b><br /><br />';
				
				$i=0;
				
				foreach ( $stmt->fetchall() as $value){
											
						echo $value['name'] . '<br />';
						$i++;
				}
				
				if ($i === 0) echo 'No Results';
						
				
				
			} catch(PDOException $e) {
    	
					echo 'ERROR: ' . $e->getMessage();
				}
				
		}					
		?>		
		
	</div>
	</div>
		
</body>

</html>
