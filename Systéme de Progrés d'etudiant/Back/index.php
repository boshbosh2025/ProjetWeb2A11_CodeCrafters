<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLivre Admin</title>
    <link rel="icon" type="image/png" href="../Ressources/logo.png">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>


<hr>
<div class="container">
   <div class="row">
      <div class="col-sm-10">
         <h1>Backoffice Management:</h1>
      </div>

   </div>
   <div class="row">
      <div class="col-sm-3">
      
         <ul class="list-group">
            <li class="list-group-item text-muted">Data:</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Name</strong></span> Nour Eslem Khediri</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span> NourKhediri@esprit.tn</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Phone</strong></span> +215 46 375 885</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Course Creation</strong></span> 11/11/2023</li>
         </ul>
      </div>
    
      <div class="col-sm-9">
         <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#home" data-toggle="tab">Last Treatment</a></li>
            <li><a href="#messages" data-toggle="tab">Appointment History</a></li>
            <li><a href="#settings" data-toggle="tab">Edit User</a></li>
         </ul>
         <div class="tab-content">
            <div class="tab-pane active" id="home">
               <div class="table-responsive">
                  <table class="table table-hover">
                     <thead>
                        <tr>
                           <th>Date</th>
                           <th>Price</th>
                           <th>Username</th>
                           <th>User Type</th>
                           <th>Notes</th>
                           <th>Edit</th>
                        </tr>
                     </thead>
                     <tbody id="items">
                        <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle ">
                           <td>10.05.2024</td>
                           <td>80$</td>
                           <td>Ahmed Andoulsi</td>
                           <td>Student</td>
                           <td>the client prefers Node.js courses</td>
                           <td><button type="button" data-toggle="modal" data-target="#edit" data-uid="1" class="update btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button></td>
                           <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                        </tr>
                        <tr>
                           <td colspan="12" class="hiddenRow">
                              <div class="accordian-body collapse" id="demo1">
                                 <table class="table table-striped">
                                    <h1>Treatment Details</h1>
                                    <tbody>
                                       <tr id='addr0'>
                                          <td>
                                          </td>
                                          <td>
                                             <input type="text" name='name0'  placeholder='Name' class="form-control"/>
                                          </td>
                                          <td>
                                             <input type="text" name='mail0' placeholder='Mail' class="form-control"/>
                                          </td>
                                          <td>
                                             <input type="text" name='mobile0' placeholder='Mobile' class="form-control"/>
                                          </td>
                                       </tr>
                                       <tr id='addr1'></tr>
                                    </tbody>
                                 </table>
                                 <a id="add_row" class="btn btn-default pull-left">Add Row</a><a id='delete_row' class="pull-right btn btn-default">Delete Row</a>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <hr>
                  <div class="row">
                     <div class="col-md-6 col-md-offset-4 text-center">
                        <ul class="pagination" id="myPager"></ul>
                     </div>
                  </div>
               </div>
         
               <div id="edit" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">×</button>
                           <h4 class="modal-title">Edit Data for (service)</h4>
                        </div>
                        <div class="modal-body">
                           <input id="fn" type="text" class="form-control" name="fname" placeholder="Products Used">
                           <input id="ln" type="text" class="form-control" name="fname" placeholder="Colors Used">
                           <input id="mn" type="text" class="form-control" name="fname" placeholder="Notes">
                        </div>
                        <div class="modal-footer">
                           <button type="button" id="up" class="btn btn-success" data-dismiss="modal">Update</button>
                           <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>
            </div>
          
            <div class="tab-pane" id="messages">
               <h2></h2>
               <div class="table-responsive">
                  <table class="table table-hover">
                     <thead>
                        <tr>
                           <th>Date</th>
                           <th>Service</th>
                           <th>Edit</th>
                        </tr>
                     </thead>
                     <tbody id="items">
                        <tr>
                           <td>10.05.2017</td>
                           <td>BACK MASSAGE</td>
                           <td><button type="button" data-toggle="modal" data-target="#edit" data-uid="1" class="update btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         
            <div class="tab-pane" id="settings">
               <hr>
               <form class="form" action="##" method="post" id="registrationForm">
                  <div class="form-group">
                     <div class="col-xs-6">
                        <label for="first_name">
                           <h4>Name</h4>
                        </label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="name" title="Enter name">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-6">
                        <label for="last_name">
                           <h4>Last Name</h4>
                        </label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" title="Enter last name">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-6">
                        <label for="mobile">
                           <h4>Phone</h4>
                        </label>
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="enter phone number" title="enter phone number">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-6">
                        <label for="email">
                           <h4>Email</h4>
                        </label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="your@email.com" title="Enter email">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                        <br>
                        <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                        <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
    
      </div>
     
   </div>
   
</div>

</hr>
</body>
</html>
