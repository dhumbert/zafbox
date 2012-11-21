<?php Section::start('content'); ?>
  
  <h2><?php echo $test->description; ?></h2>

  <p>
    <a href="<?php echo $test->url; ?>" target="_blank"><?php echo $test->url; ?></a>
    <i class="icon-share"></i>    
  </p>

  <p>
    <?php echo HTML::link_to_route('test_run', 'Run Test', array($test->id), array('data-token' => Session::token(), 'data-method' => 'PUT', 'class' => 'btn btn-success')); ?>
  </p>

  <?php if (count($logs) > 0): ?>
    <table class="table table-striped">
      <?php foreach ($logs as $log): ?>
        <tr class="<?php echo $log->passed ? 'success' : 'error'; ?>">
          <td><?php echo $log->message; ?></td>
          <td><?php echo DateFmt::Format('AGO[t]IF-FAR[d##my]', strtotime($log->created_at)); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <p>This test has never been run.</p>
  <?php endif; ?>

<?php Section::stop(); ?>