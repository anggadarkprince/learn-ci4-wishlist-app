export default function () {
    /**
     * url: /wishlist/{new/({:id/edit})}
     * Input sub task assignment
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    const formWishlist = $('#form-wishlist');
    const tableWishlist = formWishlist.find('#table-wishlist-detail');
    const inputWishlistDetail = formWishlist.find('#input-wishlist-detail');
    const btnAddWishlist = formWishlist.find('#btn-add-wishlist');

    btnAddWishlist.on('click', function (e) {
        e.preventDefault();

        if (inputWishlistDetail.val().trim()) {
            const placeholderRow = tableWishlist.find('tbody tr.row-placeholder');
            if (placeholderRow.length) {
                placeholderRow.remove();
            }

            const lastRow = tableWishlist.find('tbody tr').not('.row-placeholder').length;
            const templateRow = `
                <tr>
                    <td>${lastRow + 1}</td>
                    <td class="label-detail">${inputWishlistDetail.val()}</td>
                    <td class="text-right">
                        <input type="hidden" name="details[][detail]" id="detail" value="${inputWishlistDetail.val()}">
                        <input type="hidden" name="details[][completed_at]" id="completed_at" value="">
                        <input type="hidden" name="details[][completed_by]" id="completed_by" value="">
                        <button class="btn btn-outline-danger btn-delete" type="button">
                            <i class="mdi mdi-trash-can-outline mr-0"></i>
                        </button>
                    </td>
                </tr>
            `;
            tableWishlist.find('tbody').first().append(templateRow);
            inputWishlistDetail.val('');
            inputWishlistDetail.focus();

            reorderRows('details', tableWishlist);
        } else {
            inputWishlistDetail.focus();
        }
    });

    tableWishlist.on('click', '.btn-delete', function (e) {
        e.preventDefault();

        $(this).closest('tr').remove();

        if (tableWishlist.find('tbody tr').length === 0) {
            tableWishlist.find('tbody').append(`
                <tr class="row-placeholder">
                    <td colspan="3">No sub task available</td>
                </tr>
            `);
        }

        reorderRows('details', tableWishlist);
    });

    function reorderRows(inputName, table) {
        table.find('tbody tr').not('.row-placeholder').each(function (index) {
            // recount row number
            $(this).children('td').first().html((index + 1).toString());

            // reorder index of inputs
            $(this).find('input[name]').each(function () {
                const pattern = new RegExp(inputName + "[([0-9]*\\)?]", "i");
                const attributeName = $(this).attr('name').replace(pattern, inputName + '[' + index + ']');
                $(this).attr('name', attributeName);
            });
        });
    }

};