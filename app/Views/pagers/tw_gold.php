<?php $pager->setSurroundCount(2); ?>
<nav aria-label="Product pagination" class="pagination-wrapper">
  <ul class="pagination">
    <?php if ($pager->hasPrevious()): ?>
      <li><a href="<?= $pager->getFirst() ?>"  aria-label="First">«</a></li>
      <li><a href="<?= $pager->getPrevious() ?>" aria-label="Previous">‹</a></li>
    <?php else: ?>
      <li class="disabled"><span>«</span></li>
      <li class="disabled"><span>‹</span></li>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link): ?>
      <li <?= $link['active'] ? 'class="active"' : '' ?>>
        <?php if ($link['active']): ?>
          <span aria-current="page"><?= $link['title'] ?></span>
        <?php else: ?>
          <a href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>

    <?php if ($pager->hasNext()): ?>
      <li><a href="<?= $pager->getNext() ?>" aria-label="Next">›</a></li>
      <li><a href="<?= $pager->getLast() ?>" aria-label="Last">»</a></li>
    <?php else: ?>
      <li class="disabled"><span>›</span></li>
      <li class="disabled"><span>»</span></li>
    <?php endif; ?>
  </ul>
</nav>
