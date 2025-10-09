@props([
    'member' => [
        'id' => '',
        'photo' => null,
        'name' => '',
        'role' => '',
        'experience' => '',
        'location' => '',
        'specialties' => [],
        'brief' => '',
        'social' => [
            'linkedin' => null,
            'twitter' => null,
            'github' => null,
            'dribbble' => null,
            'behance' => null,
            'stackoverflow' => null,
            'kaggle' => null,
            'email' => null
        ]
    ]
])

<div class="team-member" data-member="{{ $member['id'] }}">
    <div class="member-photo">
        @if($member['photo'])
            <img src="{{ asset($member['photo']) }}" alt="{{ $member['name'] }}">
        @else
            <div class="photo-placeholder">
                <i class="fas fa-user-tie"></i>
            </div>
        @endif
        <div class="member-overlay">
            <div class="overlay-content">
                <div class="member-quick-info">{{ $member['experience'] }} • {{ $member['location'] }}</div>
                <span class="view-profile-btn">
                    <i class="fas fa-eye"></i> View Profile
                </span>
            </div>
        </div>
    </div>
    <div class="member-info">
        <h3 class="member-name">{{ $member['name'] }}</h3>
        <p class="member-role">{{ $member['role'] }}</p>
        <div class="member-specialties">
            @foreach($member['specialties'] as $specialty)
                <span class="specialty-tag">{{ $specialty }}</span>
            @endforeach
        </div>
        <p class="member-brief">{{ $member['brief'] }}</p>
        <div class="social-links">
            @if($member['social']['linkedin'])
                <a href="{{ $member['social']['linkedin'] }}" class="social-link" aria-label="LinkedIn">
                    <i class="fab fa-linkedin"></i>
                </a>
            @endif
            @if($member['social']['twitter'])
                <a href="{{ $member['social']['twitter'] }}" class="social-link" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
            @endif
            @if($member['social']['github'])
                <a href="{{ $member['social']['github'] }}" class="social-link" aria-label="GitHub">
                    <i class="fab fa-github"></i>
                </a>
            @endif
            @if($member['social']['dribbble'])
                <a href="{{ $member['social']['dribbble'] }}" class="social-link" aria-label="Dribbble">
                    <i class="fab fa-dribbble"></i>
                </a>
            @endif
            @if($member['social']['behance'])
                <a href="{{ $member['social']['behance'] }}" class="social-link" aria-label="Behance">
                    <i class="fab fa-behance"></i>
                </a>
            @endif
            @if($member['social']['stackoverflow'])
                <a href="{{ $member['social']['stackoverflow'] }}" class="social-link" aria-label="Stack Overflow">
                    <i class="fab fa-stack-overflow"></i>
                </a>
            @endif
            @if($member['social']['kaggle'])
                <a href="{{ $member['social']['kaggle'] }}" class="social-link" aria-label="Kaggle">
                    <i class="fab fa-kaggle"></i>
                </a>
            @endif
            @if($member['social']['email'])
                <a href="mailto:{{ $member['social']['email'] }}" class="social-link" aria-label="Email">
                    <i class="fas fa-envelope"></i>
                </a>
            @endif
        </div>
    </div>
</div>

<style>
.team-member {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
}

.team-member:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.team-member::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #FF4900, #FF6B3D);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.team-member:hover::before {
    opacity: 1;
}

.member-photo {
    width: 100%;
    height: 280px;
    background: linear-gradient(135deg, #FF4900, #FF6B3D);
    position: relative;
    overflow: hidden;
}

.member-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.team-member:hover .member-photo img {
    transform: scale(1.05);
}

.photo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 4rem;
    background: linear-gradient(135deg, #FF4900, #FF6B3D);
}

.member-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
    padding: 2rem 1.5rem 1rem;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.team-member:hover .member-overlay {
    transform: translateY(0);
}

.overlay-content {
    text-align: center;
}

.member-quick-info {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.view-profile-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.view-profile-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.member-info {
    padding: 2rem 1.5rem;
    text-align: center;
}

.member-name {
    font-size: 1.4rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    color: #1a1a1a;
}

.member-role {
    font-size: 1rem;
    color: #FF4900;
    margin-bottom: 1rem;
    font-weight: 600;
}

.member-specialties {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
    margin-bottom: 1rem;
}

.specialty-tag {
    background: #f8f9fa;
    color: #666;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
}

.member-brief {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.5;
    margin-bottom: 1.5rem;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.social-link {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.social-link:hover {
    background: #FF4900;
    color: white;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .member-photo {
        height: 240px;
    }
    
    .member-info {
        padding: 1.5rem 1rem;
    }
    
    .member-name {
        font-size: 1.2rem;
    }
}
</style>