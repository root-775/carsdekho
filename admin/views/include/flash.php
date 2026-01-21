    <?php if ($flash = getFlash()): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show mt-3" role="alert">
            <?= htmlspecialchars($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
<?php endif; ?>