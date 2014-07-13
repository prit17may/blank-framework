<style>
    .error-template{
        padding: 40px 15px;
        text-align: center;
    }
    .error-actions {
        margin-top:15px;
        margin-bottom:15px;
    }
    .error-actions .btn {
        margin-right:10px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1> Oops!</h1>
                <h2> 403 Access Forbidden</h2>
                <div class="error-details">
                    You Don't have permissions to perform this task.
                </div>
                <div class="error-actions">
                    <a href="<?php echo main_url ?>" class="btn btn-primary btn-lg">
                        <span class="fa fa-home"></span> Take Me Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
