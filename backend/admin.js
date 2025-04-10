$(document).ready(function () {
    // edit user modal
    $('.editUserBtn').click(function () {
        // Get user data from the row
        var id = $(this).data('id');
        var firstname = $(this).closest('tr').find('td:eq(1)').text();
        var lastname = $(this).closest('tr').find('td:eq(2)').text();
        var dob = $(this).closest('tr').find('td:eq(3)').text();
        var phone = $(this).closest('tr').find('td:eq(4)').text();
        var email = $(this).closest('tr').find('td:eq(5)').text();
        var password = $(this).closest('tr').find('td:eq(6)').text();
        var role = $(this).closest('tr').find('td:eq(7)').text();

        // Populate the edit modal with user data
        $('#editUserId').val(id);
        $('#editFirstname').val(firstname);
        $('#editLastname').val(lastname);
        $('#editDob').val(dob);
        $('#editPhone').val(phone);
        $('#editEmail').val(email);
        $('#editPassword').val(password);
        $('#editRole').val(role);
    });
    // delete user modal
    // Open delete user modal when delete button is clicked
    $(".deleteUserBtn").click(function () {
        var userId = $(this).data("id");
        $("#confirmDeleteUser").data("id", userId); // Set user id to the delete button
        $("#deleteUserModal").modal("show");
    });

    // Delete user when confirm button is clicked
    $("#confirmDeleteUser").click(function () {
        var userId = $(this).data("id");
        $.ajax({
            url: "delete_user.php",
            type: "POST",
            data: { id: userId },
            success: function (response) {
                alert(response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    // edit team modal
    $('.editTeamBtn').click(function () {
        var id = $(this).data('id');
        var email = $(this).closest('tr').find('td:eq(1)').text();
        var password = $(this).closest('tr').find('td:eq(2)').text();
        var role = $(this).closest('tr').find('td:eq(3)').text();

        $('#editTeamId').val(id);
        $('#editTeamEmail').val(email);
        $('#editTeamPassword').val(password);
        $('#editTeamRole').val(role);
    });
    // delete team modal
    // Open delete team member modal
    $('.deleteTeamBtn').click(function () {
        var id = $(this).data('id');
        $('#deleteTeamModal').data('id', id).modal('show');
    });

    // Delete team member
    $('#confirmDeleteTeam').click(function () {
        var id = $('#deleteTeamModal').data('id');
        $.ajax({
            url: 'delete_team_member.php',
            type: 'POST',
            data: { id: id },
            success: function (response) {
                alert(response);
                location.reload(); // Reload page after deletion
            },
            error: function (xhr, status, error) {
                alert('An error occurred while deleting the team member.');
                console.error(xhr.responseText);
            }
        });
    });
    //navbar
    $(".nav-link").click(function () {
        $(".nav-link").removeClass("active");
        $(this).addClass("active");
        var tabId = $(this).attr('href');
        $(".tab-pane").removeClass("show active");
        $(tabId).addClass("show active");

        // Save active tab to session storage
        var activeTab = $(this).attr('href').substr(1);
        sessionStorage.setItem('active_tab', activeTab);
    });

    // Retrieve active tab from session storage
    var activeTab = sessionStorage.getItem('active_tab');
    if (activeTab) {
        $(".nav-link[href='#" + activeTab + "']").click();
    }

    // Redirect to the same tab after add user
    $("#addUserModal").on('hidden.bs.modal', function () {
        $(".nav-link[href='#usersTable']").click();
    });

    // Redirect to the same tab after edit or delete action in user table
    $(".editUserBtn, .deleteUserBtn").click(function () {
        $(".nav-link[href='#usersTable']").click();
    });

    // Redirect to the same tab after add team member
    $("#addTeamModal").on('hidden.bs.modal', function () {
        $(".nav-link[href='#teamTable']").click();
    });

    // Redirect to the same tab after edit or delete action in team table
    $(".editTeamBtn, .deleteTeamBtn").click(function () {
        $(".nav-link[href='#teamTable']").click();
    });
});
