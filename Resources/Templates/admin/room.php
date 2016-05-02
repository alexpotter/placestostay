<!html>
<html>
<head>
    <title>Places to Stay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- jQuery -->
    <script src="<?php echo $this->fileUrl('dist/js/jquery.min.js'); ?>"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo $this->fileUrl('bootstrap/css/bootstrap.css'); ?>">
    <script type="text/javascript" src="<?php echo $this->fileUrl('bootstrap/js/bootstrap.js'); ?>"></script>
    <!-- Custom scripts -->
    <link rel="stylesheet" href="<?php echo $this->fileUrl('dist/css/style.css'); ?>">
    <script type="text/javascript" src="<?php echo $this->fileUrl('dist/js/frontend.js'); ?>"></script>

    <!-- Date Stuff -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#dateFrom" ).datepicker();
            $( "#dateTo" ).datepicker();
        });
    </script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $this->url('admin'); ?>">Places to Stay Admin</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo $this->url('admin/add-location'); ?>">Add Location</a></li>
                <li><a href="<?php echo $this->url('admin/add-room'); ?>">Add Room</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">API Settings</a></li>
                        <li><a href="<?php echo $this->url('admin/logout'); ?>">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form method="post" about="<?php echo $this->url('admin/add-room'); ?>">
            <div class="col-xs-6">
                <div class="form-group">
                    <select name="locations" class="form-control">
                        <?php foreach ($locations as $location): ?>
                            <option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <input class="form-control" name="description" placeholder="Description">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <input class="form-control" type="text" id="dateFrom" placeholder="Date To">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="dateTo" placeholder="Date From">
                </div>
                <div class="col-md-4">
                    <input type="number" name="price" class="form-control" placeholder="Price">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px;">
                    <input class="btn btn-success btn-lg" type="submit" value="Add Room">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>