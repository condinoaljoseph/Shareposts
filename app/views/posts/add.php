<?php require_once APP_ROOT.'/views/includes/header.php';?>
    <a href="<?php echo URL_ROOT; ?>/posts" class="btn btn-dark"><i class="fa fa-chevron-left"></i> Back</a>
    <div class="card card-body bg-light mt-5">
        <h2>Add Post</h2>
        <p>Create a post with this form</p>
        <form action="<?php echo URL_ROOT; ?>/posts/add" method="POST">
            <div class="form-group">
                <label for="title">Title: <sup>*</sup></label>
                <input type="text" name="title" class="form-control <?php echo (!empty($data['title_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                <span class="invalid-feedback"><?php echo $data['title_error']; ?></span>
            </div>
            <div class="form-group">
                <label for="body">Body: <sup>*</sup></label>
                <textarea type="text" name="body" class="form-control <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
                <span class="invalid-feedback"><?php echo $data['body_error']; ?></span>
            </div>
            <input type="submit" value="Submit" class="btn btn-success">
        </form>
    </div>
<?php require_once APP_ROOT.'/views/includes/footer.php';?>