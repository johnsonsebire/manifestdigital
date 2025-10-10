@props([
    'projects' => [],
    'showNavigation' => true,
    'showProgressBar' => true,
    'autoPlay' => true,
    'animateOnScroll' => true
])

@php
$defaultProjects = [
    ['name' => 'My Help Your Help Foundation', 'image' => 'myhelpyourhelp.png', 'url' => 'https://myhelpyourhelp.org'],
    ['name' => 'L-Time Properties', 'image' => 'ltimeproperties.png', 'url' => 'https://ltimepropertiesltd.com'],
    ['name' => 'Koko Plus Foundation', 'image' => 'kokoplus.png', 'url' => 'https://kokoplusfoundation.org'],
    ['name' => 'Good News Library', 'image' => 'goodnewslibrary.png', 'url' => 'https://goodnewslibrary.com'],
    ['name' => 'Barjul Travels', 'image' => 'barjultravels.png', 'url' => 'https://barjultravels.com'],
    ['name' => 'YOVI Ghana', 'image' => 'yovighana.png', 'url' => 'https://yovighana.org'],
    ['name' => 'Yensoft Ghana', 'image' => 'yensoftgh.png', 'url' => 'https://yensoftgh.com'],
    ['name' => 'VAMG Research Institute', 'image' => 'vamg.png', 'url' => 'https://vamgresearchinstitute.org'],
    ['name' => 'Trade Growth Network', 'image' => 'tradegrowth.png', 'url' => 'https://tradegrowthnetwork.org'],
    ['name' => 'The Watered Garden Foundation', 'image' => 'wateredgarden.png', 'url' => 'https://thewateredgardenfoundation.org'],
    ['name' => 'The Travel O Africa', 'image' => 'thetraveloafrica.png', 'url' => 'https://thetraveloafrica.com'],
    ['name' => 'The Push Studios', 'image' => 'thepushstudios.png', 'url' => 'https://thepushstudios.com'],
    ['name' => 'The FCB Foundation', 'image' => 'fcbfoundation.png', 'url' => 'https://thefcbfoundation.org'],
    ['name' => 'The Alpha Health Group', 'image' => 'alphahealthgroup.png', 'url' => 'https://thealphahealthgroup.org'],
    ['name' => 'SOVODEG', 'image' => 'sovodeg.png', 'url' => 'https://sovodeg.org'],
    ['name' => 'Samak Technology', 'image' => 'samaktechnology.png', 'url' => 'https://samaktechnology.com'],
    ['name' => 'Richard Akita', 'image' => 'richardakita.png', 'url' => 'https://richardakita.com'],
    ['name' => 'Resource Interlink', 'image' => 'resourceinterlink.png', 'url' => 'https://resourceinterlink.co.uk'],
    ['name' => 'Relax Airlines', 'image' => 'relaxairlines.png', 'url' => 'https://relaxairlines.com'],
    ['name' => 'PNMTC', 'image' => 'pnmtc.png', 'url' => 'https://pnmtc.edu.gh'],
    ['name' => 'Peachera', 'image' => 'peachera.png', 'url' => 'https://peachera.org'],
    ['name' => 'Nkunim', 'image' => 'nkunim.png', 'url' => 'https://nkunim.org'],
    ['name' => 'Martha\'s Beauty Supply', 'image' => 'marthasbeauty.png', 'url' => 'https://marthasbeautysupply.us'],
    ['name' => 'Manifest Ghana', 'image' => 'manifestghana.png', 'url' => 'https://manifestghana.com'],
    ['name' => 'Johnson Sebire', 'image' => 'johnsonsebire.png', 'url' => 'https://johnsonsebire.com'],
    ['name' => 'Jaglah Sterile', 'image' => 'jaglahsterile.png', 'url' => 'https://jaglahsterile.com'],
    ['name' => 'Jaglah Foundation', 'image' => 'jaglahfoundation.png', 'url' => 'https://jaglahfoundation.com'],
    ['name' => 'HF Liberia', 'image' => 'hfliberia.png', 'url' => 'https://hfliberia.com'],
    ['name' => 'Global HR Consulting', 'image' => 'globalhrconsulting.png', 'url' => 'https://globalhrconsulting.org'],
    ['name' => 'Global AZ Services', 'image' => 'globalazservices.png', 'url' => 'https://globalazserviceslda.com'],
    ['name' => 'Get The Artiste', 'image' => 'gettheartiste.png', 'url' => 'https://gettheartiste.com'],
    ['name' => 'FMS Foundation', 'image' => 'fmsfoundation.png', 'url' => 'https://fmsfoundation.org'],
    ['name' => 'Everything Me', 'image' => 'everythingme.png', 'url' => 'https://everything-me.com'],
    ['name' => 'Cosello Apparel', 'image' => 'coselloapparel.png', 'url' => 'https://coselloapparel.com'],
    ['name' => 'Coconut Pointe', 'image' => 'coconutpointe.png', 'url' => 'https://coconutpointe.com'],
    ['name' => 'Cliq Host', 'image' => 'cliqhost.png', 'url' => 'https://cliqhost.space'],
    ['name' => 'Christian Missions Online', 'image' => 'christianmissions.png', 'url' => 'https://christianmissionsonline.org'],
    ['name' => 'Chrissy Foundation', 'image' => 'chrissyfoundation.png', 'url' => 'https://chrissyfoundation.org'],
    ['name' => 'CCEM Ghana', 'image' => 'ccemghana.png', 'url' => 'https://ccemghana.org'],
    ['name' => 'Bosch School of Ministry', 'image' => 'boschschool.png', 'url' => 'https://boschschoolofministry.com']
];

$projectList = empty($projects) ? $defaultProjects : $projects;
@endphp

<section class="slider{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">
    <div class="projects">
        @foreach($projectList as $project)
            <div class="project">
                <img src="{{ asset('images/projects/' . $project['image']) }}" alt="{{ $project['name'] }}" />
                <a href="{{ $project['url'] }}" class="project-label" target="_blank">
                    <i class="fa-solid fa-up-right-from-square mx-2"></i> {{ $project['name'] }}
                </a>
            </div>
        @endforeach
    </div>
    
    @if($showNavigation)
        <div class="slider-nav">
            @if($showProgressBar)
                <div class="progress-track">
                    <div class="progress-bar"></div>
                    <div class="progress-indicator"></div>
                </div>
            @endif
            <div class="slider-buttons">
                <button class="prev" aria-label="Previous"><i class="fas fa-arrow-left"></i></button>
                <button class="next" aria-label="Next"><i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    @endif
</section>