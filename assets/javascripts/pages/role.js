export default function () {

    /**
     * url: /master/role/{create/({edit/:id})}
     * Toggle check all permissions in same module name, find by class name.
     */
    $('#form-role').find('.check_all').on('change', function () {
        let module = $(this).val();
        if ($(this).is(":checked")) {
            $('.' + module).prop('checked', true);
        }
        else {
            $('.' + module).prop('checked', false);
        }
    });

    /**
     * url: /master/role/edit/:id
     * When edit the roles, find out if all modules is being checked,
     * then "check all" checkbox of that module should be in checked state as well.
     */
    $('#form-role.edit').find('.check_all').each(function () {
        let module = $(this).val();
        let isCheckedAll = true;
        $('.' + module).each(function () {
            if (!$(this).is(":checked")) {
                isCheckedAll = false;
            }
        });

        if (isCheckedAll) {
            $(this).prop('checked', true);
        }
    });
};