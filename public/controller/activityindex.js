window.operateEvents = {
            'click .RoleOfdelete': function (e, value, row, index) {
                alert(row.dno);            
         },
            'click .RoleOfedit': function (e, value, row, index) {
                $("#editModal").modal('show');

            }
    };
