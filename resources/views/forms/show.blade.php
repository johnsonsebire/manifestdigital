<x-layouts.inner-pages :title="$form->title" :preloader="'none'" :transparentHeader="true" :notificationStyle="'detailed'">
    <!-- Form Section -->
    <section class="form-section">
        <div class="container">
            <div class="form-header">
                <h1>{!! $form->title !!}</h1>
                @if($form->description)
                    <p class="section-subtitle">{!! $form->description !!}</p>
                @endif
            </div>
        </div>
    </section>
    
    <div class="container">
        <div class="custom-form">
            @include('forms.partials.form')
        </div>
    </div>
    
    <!-- Add some spacing after the form container -->
    <div style="padding: 80px 0;"></div>

    <style>
        /* Hero section styling */
        .form-section {
            padding: 80px 0;
            position: relative;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            overflow: hidden;
            margin-bottom: -40px;
        }
        
        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('../manifest-template/images/decorative/hero_left_mem_dots_f_circle3.svg') no-repeat left center,
                url('../manifest-template/images/decorative/hero_right_circle-con3.svg') no-repeat right center;
            background-size: 300px, 250px;
            opacity: 0.1;
            z-index: 1;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto 40px;
            padding: 0 20px;
        }
        
        .form-header h1 {
            font-family: 'Anybody', sans-serif;
            font-weight: 800;
            font-size: 48px;
            margin-bottom: 24px;
            line-height: 1.2;
        }
        
        .form-header .section-subtitle {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .custom-form {
            max-width: 1000px;
            margin: -40px auto 0;
            background: #fff;
            padding: 50px 60px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 3;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-header h1 {
                font-size: 36px;
            }
            
            .form-header .section-subtitle {
                font-size: 18px;
            }
            
            .custom-form {
                margin: -20px 20px 0;
                padding: 30px 24px;
                border-radius: 16px;
            }
        }
    </style>
</x-layouts.inner-pages>