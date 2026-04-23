<?php
$flash = getFlash();
if ($flash): ?>
    <div class="alert alert-<?= $flash['type']; ?>">
        <?= $flash['message']; ?>
    </div>
<?php endif; ?>