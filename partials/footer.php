</main>
<footer class="footer">
  <div class="fb">★ <span id="footName"></span></div>
  <div class="fs" id="footSlogan"></div>
  <div id="footNote"></div>
  <div class="foot-links" id="footLinks"></div>
  <div class="footer-nl" style="justify-content:center;margin-top:12px">
    <input type="email" id="nlEmail" dir="ltr" style="max-width:220px">
    <button class="btn gold sm" type="button" id="nlBtn"></button>
  </div>
</footer>
<button id="kbotBtn" type="button" aria-expanded="false" aria-controls="kbot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.8-.9L3 21l1.9-5.1A8.4 8.4 0 0 1 12 3a8.4 8.4 0 0 1 9 8.5z"/><path d="M8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01"/></svg><span class="sr-only" id="kbotBtnLbl"></span></button>
<div id="kbot" hidden>
  <div class="kbot-head"><span id="kbotTitle">🤖</span><button id="kbotClose" type="button"><span aria-hidden="true">✕</span><span class="sr-only" id="kbotCloseLbl"></span></button></div>
  <div class="kbot-msgs" id="kbotMsgs"></div>
  <div class="kbot-chips" id="kbotChips"></div>
  <form id="kbotForm" autocomplete="off"><input id="kbotIn" maxlength="200"><button type="submit" aria-label="send">➤</button></form>
</div>
<div class="toast" id="toast"></div>
<script>window.__BOOT = { view: <?= json_encode($BOOT_VIEW, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>, arg: <?= json_encode($BOOT_ARG, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?> };</script>
<script src="assets/app.js"></script>
</body>
</html>
