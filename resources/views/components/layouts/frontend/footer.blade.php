 @props([
     'class' => '',
     'ctaHeading' => 'Ready to take your project to the next level?',
     'ctaButtonText' => 'Get Started',
 ])
 <section class="cta-footer {{ $class }}">
     <div class="cta">
         <!-- Decorative elements for CTA section -->
         <img src="{{ asset('images/decorative/cta_left_mem_dots_f_circle2.svg') }}" alt=""
             class="decorative-element cta-left">
         <img src="{{ asset('images/decorative/cta_top_right_mem_dots_f_tri.svg') }}" alt=""
             class="decorative-element cta-top-right">
         <img src="{{ asset('images/decorative/right_under_cta_mem_dots_f_circle2.svg') }}" alt=""
             class="decorative-element cta-right-under">
         <img src="{{ asset('images/decorative/left_under_cta_mem_dots_f_tri.svg') }}" alt=""
             class="decorative-element cta-left-under">

         <h2>{{ $ctaHeading }}</h2>
         <a href="{{ url('get-started') }}" class="btn-cta">{{ $ctaButtonText }}</a>
         <!-- <img src="images/decorative/left_under_footer_mem_donut (1).svg" alt="" class="decorative-element cta-button-donut"> -->
     </div>
     <footer>
         <div class="footer-content">
             <div class="footer-logo"></div>
             <x-layouts.frontend.footer-navigation />
         </div>
         <div class="social">
             <h3 class="social-heading">Connect With Us</h3>
             <div class="social-icons">
                 <a href="#" class="social-icon" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
                 <a href="#" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                 <a href="#" class="social-icon" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                 <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
             </div>
         </div>
         <div class="copyright">
             <p>Copyright {{ date('Y') }} - Manifest Digital</p>
         </div>
     </footer>
 </section>

 <!-- Scroll to top button -->
 <button class="scroll-to-top" aria-label="Scroll to top">
     <i class="fas fa-arrow-up"></i>
 </button>

 <!-- Alpine.js -->
 <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

 <!-- Bootstrap JS -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

 <!-- Custom Scripts -->
 @vite(['resources/js/scripts','resources/js/app'])

 <!-- Stack for additional scripts -->
 @stack('scripts')


 </body>

 </html>
