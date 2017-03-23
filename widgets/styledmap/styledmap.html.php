<style>
.styledmap-license-box {
  display: flex;
  align-items: center;
}
.styledmap-license-box a {
  font-weight: 600;
  white-space: nowrap;
}
.styledmap-license-box a:after {
  content: "›";
  padding-left: .25em;
}
</style>
<div class="styledmap-box styledmap-license-box">
  <div style="padding: 0 1em 0 0;">
    <span class="fa fa-warning fa-2x"></span>
  </div>
  <div class="text">
    <?php echo $text ?>
  </div>
</div>
