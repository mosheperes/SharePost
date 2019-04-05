<?php require APPROOT . '/views/inc/header.php';?>

   <div class="row">
       <div class="col-md-6 mx-auto">
           <div class="card card-body bg-light mt-5">
               <h2>Create An Account</h2>
               <p>Please fill out the following form to get started.</p>
               <form action="<?php echo URLROOT; ?>/users/register" method="post">
                 <div class="form-group">
                       <label for="email">Email: <sup>*</sup></label>
                       <input type="email" name="email" id="email" class="form-control form-control-lg <?php echo (!empty($data['email_err']))? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                       <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                 </div>
                 <div class="form-group">
                     <label for="name">Name: <sup>*</sup></label>
                     <input type="text" name="name" id="name" class="form-control form-control-lg <?php echo (!empty($data['name_err']))? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                     <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                 </div>
                 <div class="form-group">
                       <label for="password">Password: <sup>*</sup></label>
                       <input type="password" name="password" id="password" class="form-control form-control-lg <?php echo (!empty($data['password_err']))? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                       <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                   </div>
                   <div class="form-group">
                       <label for="confirm-password">Confirm Password: <sup>*</sup></label>
                       <input type="password" name="confirm-password" id="confirm-password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err']))? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                       <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                   </div>

                            <!--the submit button is here -->
                   <div class="row">
                       <div class="col">
                           <input type="submit" value="Join" class="btn btn-success btn-block" id="ajaxAccount">
                       </div>
                       <div class="col">
                           <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </div>


<!--<script>-->
<!--        document.getElementById('ajaxForm').addEventListener('submit', postName);-->
<!---->
<!--    function postName(e){-->
<!--        e.preventDefault();-->
<!---->
<!--        var name = document.getElementById('name').value;-->
<!--        var password=document.getElementById('password').value;-->
<!--        var params = "username= "+name +"&password="+password+"&submit=submit";-->
<!---->
<!--        var xhr = new XMLHttpRequest();-->
<!--        xhr.open('POST', 'http://localhost/SharePosts/users/register.php', true);-->
<!--        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');-->
<!---->
<!--        xhr.onload = function(){-->
<!--            console.log (this.responseText);-->
<!--        }-->
<!---->
<!--        xhr.send(params);-->
<!--    }-->
<!---->
<!--</script>-->

<?php require APPROOT . '/views/inc/footer.php'; ?>
