<!-- Edit Team Member Modal -->
<div class="modal fade" id="editTeamModal" tabindex="-1" aria-labelledby="editTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTeamModalLabel">Edit Team Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="edit_team_member.php" method="post">
                    <input type="hidden" id="editTeamId" name="editTeamId">
                    <div class="mb-3">
                        <label for="editTeamEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editTeamEmail" name="editTeamEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTeamPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editTeamPassword" name="editTeamPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTeamRole" class="form-label">Role</label>
                        <select class="form-select" id="editTeamRole" name="editTeamRole" required>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                            <option value="restaurant">Restaurant</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
