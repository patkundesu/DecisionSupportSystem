<?php require_once('../../dss-base.php') ?>
<?php
    define('ADD_PATIENT', 'add_patient');
?>
<?php if($_SESSION['isLoggedIn']): ?>

	<?php startblock('main') ?>
        <?php
            if(isset($action)){
                if($action == ADD_PATIENT){
                    addNewPatient($_POST, $_FILES);
                }
            }

            $patients = getPatientList();
        ?>
	   	<?php if($_COOKIE['privilege_level'] != 0): ?>
	   		<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addPatientModal">
                 <span class="glyphicon glyphicon-plus"></span> Add Patient
            </button>
            <a href="patient" class="btn btn-primary btn-md">
                 <span class="glyphicon glyphicon-refresh"></span> Refresh
            </a>

            <table class="table">
            	<thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Patient Name</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Last Visit</th>
                        <th>Options</th>
                    </tr>
                </thead>
            <?php if(count($patients) == 0): ?>
                <tr>
                    <td colspan="6" style="text-align:center;font-weight:bold;font-size:25px;padding:25px;">No results</td>
                </tr>
            <?php else: ?>
                <tr>
                </tr>
            <?php endif; ?>
                
            </table>
	   	<?php endif; ?>
	<?php endblock() ?>

    <div id="addPatientModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form class="modal-content" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Patient</h4>
                </div>
                <input type='hidden' name="admin_ulid" value="<?php echo $_COOKIE['adminID']; ?>" />
                <div class="modal-body">
                    <div class="image-selection">
                        <img style="margin-bottom:10px;" class="img-responsive center-block img-rounded image-selected" id="patient_photo" src="assets/placeholder.gif" alt="Insert Image" width="304" height="236">
                        <div class="row">
                            <div class="col-xs-4"></div>
                            <div class="col-xs-4">
                                <label class="btn btn-primary btn-file center-block btn-md">
                                    Browse <input type="file" style="display: none;" name="patient_picture" class="image-browser"  accept="image/*">
                                </label>
                            </div>
                            <div class="col-xs-4"></div>
                        </div>
                    </div>
                    
                    <label>First Name:</label>
                    <input class="form-control" type="text" name="first_name" required />
                    <label>Middle Name:</label>
                    <input class="form-control" type="text" name="middle_name" required />
                    <label>Last Name:</label>
                    <input class="form-control" type="text" name="last_name" required />
                    <label>Ward/Room/Bed/Service:</label>
                    <input class="form-control" type="text" name="ward" />
                    <label>Permanent Address:</label>
                    <input class="form-control" type="text" name="address" required/>
                    <label>Telephone No.:</label>
                    <input class="form-control" type="text" name="telephone" />
                    <label>Gender:</label><br/>
                    <select class="form-control" name="gender" required>
                        <option disabled selected value>Select Gender</option>
                        <option value='Male'>Male</option>
                        <option value='Female'>Female</option>
                    </select>
                    <label>Civil Status:</label>
                    <select class="form-control" name="status" required>
                        <option disabled selected value>Select Status</option>
                        <option value='Single'>Single</option>
                        <option value='Married'>Married</option>
                        <option value='Divorced'>Divorced</option>
                        <option value='Separated'>Separated</option>
                        <option value='Widowed'>Widowed</option>
                    </select>
                    <label>Date of Birth:</label>
                    <input id="dob" class="form-control" type='date' name='date_of_birth' required />
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#dob').change(function(){
                                var dob = new Date(this.value);
                                var now = new Date();
                                var age = now.getYear() - dob.getYear();
                                if(now.getMonth() < dob.getMonth()){
                                    age -= 1;
                                }else{
                                    if(now.getDay() < dob.getDay()){
                                        age -= 1
                                    }
                                }
                                
                                $("input[name=age]").val(age);
                            });
                        });
                    </script>
                    <label>Age:</label>
                    <input class="form-control" type="number" name="age" required/>
                    <label>Birthplace:</label>
                    <input class="form-control" type="text" name="place_of_birth" required/>
                    <label>Nationality:</label>
                    <input class="form-control" type="text" name="nationality" required/>
                    <label>Religion:</label>
                    <input class="form-control" type="text" name="religion" required/>
                    <label>Occupation:</label>
                    <input class="form-control" type="text" name="occupation" required/>
                    <br/>
                    
                    <label>Employer (Type of Business):</label>
                    <input class="form-control" type="text" name="employer" />
                    <label>Address:</label>
                    <input class="form-control" type="text" name="emp_address" />
                    <label>Telephone No.:</label>
                    <input class="form-control" type="text" name="emp_telephone" />
                    <br/>
                    
                    <label>Mother's Name:</label>
                    <input class="form-control" type="text" name="mother" required/>
                    <label>Address:</label>
                    <input class="form-control" type="text" name="mom_address" required/>
                    <label>Telephone No.:</label>
                    <input class="form-control" type="text" name="mom_telephone" required/>
                    <br/>
                    
                    <label>Spouse Name:</label>
                    <input class="form-control" type="text" name="spouse" />
                    <label>Address:</label>
                    <input class="form-control" type="text" name="sp_address" />
                    <label>Telephone No.:</label>
                    <input class="form-control" type="text" name="sp_telephone" />
                    <br/>

                    <label>Electronic Health Record:</label>
                    <div class="row" id="ehr_images">
                        
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label id="add_ehr" class="btn btn-primary btn-file center-block btn-md" >
                                Add Image
                            </label>
                        </div>
                    </div>
                    <script>
                        $("#add_ehr").click(function () {
                            $("#ehr_images").append('<input class="form-control" type="file" name="ehr_img[]" accept="image/*">');
                         });
                    </script>
                    <label>Height:</label>
                    <input class="form-control" type="text" name="height" required />
                    <label>Weight:</label>
                    <input class="form-control" type="text" name="weight" required />
                    <label>Blood Pressure:</label>
                    <input class="form-control" type="text" name="blood_pressure" required />
                    <label>Body Temperature:</label>
                    <input class="form-control" type="text" name="body_temperature" required />

                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="<?= ADD_PATIENT ?>" class="btn btn-default">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>

    <footer>
        <script type="text/javascript">
            $(".image-browser").change(function() {
                var input = ($(this))[0];

                if(input.files && input.files[0]){
                    var reader = new FileReader();
                    var img = $(this).closest('.image-selection').find('.image-selected');
                    reader.onload = function (e){
                        img.attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
                
            });
        </script>
    </footer>
<?php endif; ?>