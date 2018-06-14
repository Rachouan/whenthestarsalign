<section class="email-popup">
  <div class="popup">
    <div class="form">
      <header>
        <h1>Save your design?</h1>
        <p>You can come back later and edit it anytime.</p>
      </header>
      <form id="email-optin">
          <label for="emailoptin" class="animate">Email</label>
          <input type="email" name="email" id="emailoptin" placeholder="Email"/>
          <input type="submit" value="Save Design" class="button" id="save"/>
      </form>
      <button class="checkout" class="skip">Skip and Check Out</button>
    </div>
    <div class="complete">
      <header>
        <h1>Your design was saved</h1>
        <p>We have sent your design to <span class="email-adress">info@rachouanrejeb.be</span> be sure to check your spam folder if you can't find it.</p>
        <button class="button checkout"> Checkout Now </button>
      </header>
    </div>
  </div>
</section>

<section class="preloader">
  <header>
    <h1 class="precentage">100%</h1>
    <h2 class="text">Creating Your Poster</h2>
  </header>
</section>

</main>
  <script async src="js/jquery.min.js"></script>
  <script async src="js/datepicker.js?v0.7"></script>
  <script async src="js/planets.js?v0.7"></script>
  <script async src="js/app.js?v0.8"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117922911-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-117922911-1');
  </script>

  <!-- Facebook Pixel Code -->
  <script>
    ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '292979134571324');
    fbq('track', 'Creator');
  </script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=292979134571324&ev=PageView&noscript=1"
/></noscript>
  <!-- End Facebook Pixel Code -->

</body>

</html>
