<?php
    require('config.php');

    session_start();
    
    if(!isset($_SESSION['matric_number'])){
        header('Location: studentlogin.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION);
        header('Location: studentlogin.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DMS | DASHBOARD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>

     var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23019901-1']);
      _gaq.push(['_setDomainName', "bootswatch.com"]);
        _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);

     (function() {
       var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();

    </script>
  </head>
  <body>
    <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
      <div class="container">
        <a href="indexstudent.php" class="navbar-brand">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="indexstudent.php">Home</a>
            </li>            
            <li class="nav-item">
              <a class="nav-link" href="../help/">Search</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../help/">Upload Document</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="studentprofile.php">Profile</a>
            </li>
            
          </ul>

          <ul class="nav navbar-nav ml-auto">
          <li class="nav-item">
            <label style="color:white"><?php echo $_SESSION['lastname']?> <?php echo $_SESSION['firstname']?> <?php echo $_SESSION['middlename']?><a class="nav-link" href="indexstudent.php?logout=true" style="color:white">Logout</a></label>
          </li>
          
          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br></div>
    <br><br>
    <div class="container">
        
        <h2 align="center" class="cabinet_title">Cabinet</h2>
        <div align="right">
            <button type="button" id="upload_file" class="btn btn-success">Upload File</button>
        </div>
        <div id="folder_table" class="table-responsive">
          
        </div>
    </div>

</body>
</html>

<div class="modal fade" id="folderModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="change_title">Create Folder</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Enter File Name                    
                <input type="text" name="folder_name" id="folder_name" class="form-control"></p>
                <br>
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="old_name" id="old_name">
                <input type="button" name="folder_button" id="folder_button" class="btn btn-info" value="Create">
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="change_title">Upload File</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" id="upload_form" enctype="multipart/form-data">
                    <p>Select File To Upload<br>                        
                    <input type="file" name="upload_file" id="upload_file"></p>
                    <br>
                    <input type="hidden" name="hidden_folder_name" id="hidden_folder_name">
                    <input type="submit" name="upload_button" id="upload_button" class="btn btn-info" value="Upload">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filelistModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="change_title">Files</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="file_list">
              
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        load_folder_list();
        function load_folder_list()
        {
            var action = "fetch";
            $.ajax({
                url: 'action.php',
                method: 'POST',
                data: {action:action},
                success:function(data)
                {
                    $('#folder_table').html(data);
                }
            })
        }
        $(document).on('click', '#upload_file', function(){
            var folder_name = $(this).data("name");
            $('#hidden_folder_name').val(folder_name);
            $('#uploadModal').modal('show');
        });
        $(document).on('click', '#folder_button', function(){
            var action = $('#action').val();
            var folder_name = $('#folder_name').val();
            var old_name = $('#old_name').val();
            $.ajax({
                url: 'action.php',
                method: 'POST',
                data: {action:action, folder_name:folder_name, old_name:old_name},
                success:function(data)
                {
                    load_folder_list();
                    alert(data);
                    $('#folderModal').modal('hide');
                }
            })
        });
        $(document).on('click', '.update', function(){
            var folder_name = $(this).data("name");
            $('#old_name').val(folder_name);
            $('#folder_name').val(folder_name);
            $('#action').val("change");
            $('#folder_button').val('Update');
            $('#change_title').text('Rename File');
            $('#folderModal').modal('show');
        });        
        $('#upload_form').on('submit', function(){
            $.ajax({
                url: 'upload.php',
                method: 'POST',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success:function(data)
                {
                    load_folder_list();
                    alert(data);
                }
            })
        });
        $(document).on('click', '.view_files', function(){
            var folder_name = $(this).data("name");
            var action = "fetch_files";
            $.ajax({
                url: 'action.php',
                method: 'POST',
                data: {folder_name:folder_name, action:action},
                success:function(data)
                {
                    $('#filelistModal').modal('show');
                    $('#file_list').html(data);
                }
            });
        });        
        $(document).on('click', '.delete', function(){
            var folder_name = $(this).data("name");
            var action = "remove_folder";
            if(confirm("Are you sure you want to delete this file?"))
            {
                $.ajax({
                    url: 'action.php',
                    method: 'POST',
                    data: {folder_name:folder_name, action:action},
                    success:function(data)
                    {
                        load_folder_list();
                        alert(data);
                    }
                });
            }
            else
            {
                return false;
            }
        });        
    });
</script>