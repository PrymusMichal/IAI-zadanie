<html>

<head>
    <title>IAI zadanie</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/jqtree.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/tree.jquery.js"></script>
    <script type="text/javascript" src="js/jqTreeContextMenu.js"></script>
    <script type="text/javascript" src="js/treeEvents.js"></script>
    <script type="text/javascript" src="js/buttonFunctions.js"></script>

    <?php
    session_start();
    $configuration=parse_ini_file('config.ini',true);
    $_SESSION['db_host']= $configuration['database']['db_host'];
    $_SESSION['db_user']= $configuration['database']['db_user'];
    $_SESSION['db_password']=  $configuration['database']['db_password'];
    $_SESSION['db_name']=  $configuration['database']['db_name'];
    $_SESSION['table_name']=  $configuration['database']['table_name'];
    ?>
    <script>
        getNodes();
    </script>
</head>

<body>
    <p>By skorzystać ze strony przeprowadź konfigurację w pliku <b>config.ini</b>. </p>
    <p>Po ustawieniu parametrów oraz przeładowaniu strony można wypełnić zawartość bazy danych używając <b>guzika seedDatabase</b>.</p>
    <p>Elementy można przeciągać w dowolne miejsca, by rozwinąć menu kontekstowe należy użyć <b>prawego klawisza myszy</b>.</p>
    <button type="button" id="seedButton" onclick="seedDatabase()">seedDatabase </button>

    <div id="tree1"></div>

    <ul id="myMenu" class="dropdown-menu">
		<li><a href="#edit"><i class="icon-edit"></i> Edit</a></li>
		<li><a href="#delete"><i class="icon-remove"></i> Delete</a></li>
		<li class="divider"></li>
		<li><a href="#add"><i class="icon-plus"></i> Add</a></li>
	</ul>
</body>

</html>