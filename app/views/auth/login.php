<div class="auth-container">
    <h1>Login</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($errors) && is_array($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $field => $message): ?>
                    <li><?php echo $message; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="/login">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $email ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        
        <div class="form-group">
            <p>Don't have an account? <a href="/register">Register</a></p>
        </div>
    </form>
</div> 