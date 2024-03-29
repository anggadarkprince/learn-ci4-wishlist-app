<div class="modal fade" id="modal-filter" aria-labelledby="modalFilter">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url(uri_string()) ?>" id="form-filter">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFilter">Filter <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" name="search" id="search"
                               value="<?= get_url_param('search') ?>" placeholder="Search data">
                    </div>
                    <div class="form-row">
                        <div class="col-8 col-sm-6">
                            <div class="form-group">
                                <label for="sort_by">Sort By</label>
                                <select class="custom-select" name="sort_by" id="sort_by" required>
                                    <?php
                                    $filterSorts = [
                                        'created_at' => 'CREATED AT',
                                        'name' => 'NAME',
                                        'username' => 'USERNAME',
                                        'email' => 'EMAIL',
                                        'status' => 'STATUS',
                                    ]
                                    ?>
                                    <?php foreach ($filterSorts as $key => $filterSort): ?>
                                        <option value="<?= $key ?>"<?= set_select('sort_by', $key, get_url_param('sort_by') == $key) ?>>
                                            <?= $filterSort ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4 col-sm-6">
                            <div class="form-group">
                                <label for="order_method">Order</label>
                                <select class="custom-select" name="order_method" id="order_method" required>
                                    <option value="desc"
                                        <?= set_select('order_method', 'desc', get_url_param('order_method') == 'desc') ?>>
                                        DESCENDING
                                    </option>
                                    <option value="asc"
                                        <?= set_select('order_method', 'asc', get_url_param('order_method') == 'asc') ?>>
                                        ASCENDING
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="text" class="form-control datepicker" name="date_from" id="date_from" autocomplete="off"
                                       value="<?= get_url_param('date_from') ?>" placeholder="Pick create date from">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date_to">Date To</label>
                                <input type="text" class="form-control datepicker" name="date_to" id="date_to" autocomplete="off"
                                       value="<?= get_url_param('date_to') ?>" placeholder="Pick create date to">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= site_url(uri_string()) ?>" class="btn">
                        RESET
                    </a>
                    <a href="#" class="btn" data-dismiss="modal">
                        CLOSE
                    </a>
                    <button type="submit" class="btn btn-primary">
                        APPLY FILTER
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>