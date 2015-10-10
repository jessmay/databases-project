<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create RSO</title>
    <script>
		$(function() {
            $('form').on('click', '.addMember', function() {
                var start = $('#memberList'),
                newMember = $('<div class="form-group"><input type="email" class="form-control" id="rsoMemberEmail" placeholder="Email"></div>');
                $(start).append(newMember);     
                console.log(start);
            });
		});
	</script>

<?php include TEMPLATE_MIDDLE; ?>
    <h2>
        Create RSO
    </h2>
    <hr>
	<p>
		<form>
            <div class="form-group">
                <label class="control-label" for="rsoName">Name</label>
                <input type="text" class="form-control" id="rsoName" name="rsoName" placeholder="ex: Student Government Association (SGA)">
            </div>
												
            <div class="form-group">
                <label for="rsoAdminEmail">Admin Email</label>
                <input type="email" class="form-control" id="rsoAdminEmail" placeholder="ex: rsoAdmin@university.edu">
            </div>
            
            <div id="memberList">
                <label><b>List of Members</b></label>
                <div class="form-group">
                    <input type="email" class="form-control" id="rsoMemberEmail1" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="rsoMemberEmail2" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="rsoMemberEmail3" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="rsoMemberEmail4" placeholder="Email">
                </div>
            </div>
            <button type="button" class="addMember btn btn-success btn-sm">Add Member</button><br><br><br>
			
			<button type="submit" class="btn btn-primary">Submit</button>
	</p>

<?php include TEMPLATE_BOTTOM; ?>