<!-- BEGIN JOBVITE CODE -->
<iframe id="jobviteframe" src="<?php echo $jobvite_link; ?>&jvresize=<?php echo $resizer; ?>" width="100%" height="500px" scrolling="no" frameborder="0" allowtransparency =”true”>Sorry, iframes are not supported.</iframe>
<script type="text/javascript">
      var l = location.href;
      var args = '';
      var k = '';
      var iStart = l.indexOf('?jvk=');
      if (iStart == -1) iStart = l.indexOf('&jvk=');
      if (iStart != -1) {
            iStart += 5;
            var iEnd = l.indexOf('&', iStart);
            if (iEnd == -1) iEnd = l.length;
            k = l.substring(iStart, iEnd);
      }
      iStart = l.indexOf('?jvi=');
      if (iStart == -1) iStart = l.indexOf('&jvi=');
      if (iStart != -1) {
            iStart += 5;
            var iEnd = l.indexOf('&', iStart);
            if (iEnd == -1) iEnd = l.length;
            args += '&j=' + l.substring(iStart, iEnd);
            if (!k.length) args += '&k=Job';
            var iStart = l.indexOf('?jvs=');
            if (iStart == -1) iStart = l.indexOf('&jvs=');
            if (iStart != -1){
                  iStart += 5;
                  var iEnd = l.indexOf('&', iStart);
                  if (iEnd == -1) iEnd = l.length;
                  args += '&s=' + l.substring(iStart, iEnd);
            }
      }
      if (k.length) args += '&k=' + k;
      if (args.length) document.getElementById('jobviteframe').src += args;
      function resizeFrame(height, scrollToTop) {
            if (scrollToTop) window.scrollTo(0, 0);
            var oFrame = document.getElementById('jobviteframe');
            if (oFrame) oFrame.height = height;
      }
</script>
<!--END JOBVITE CODE -->