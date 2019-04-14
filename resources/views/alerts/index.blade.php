<script type="text/javascript">
  <?php if(session('msgInfo')){?>
    alertify.success('<?=session("msgInfo")?>','15');
  <?php } ?>
  <?php if(session('msgError')){?>
    alertify.error('<?=session("msgError")?>','15');
  <?php } ?>
  <?php if(session('msgWarning')){?>
    alertify.warning('<?=session("msgWarning")?>','15');
  <?php } ?>
</script>