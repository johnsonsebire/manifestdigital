@props([
    'transparentHeader' => false,
    'preloader' => 'advanced',
    'notificationStyle' => 'dark', // Options: 'dark', 'modern-purple', 'detailed'
    'title' => 'About Us | Manifest Digital - Ghana\'s Leading Digital Solutions Agency',
])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn about Manifest Digital - Ghana's leading digital solutions agency. Our story, mission, and the expert team behind innovative web and mobile solutions.">
    <meta name="keywords" content="about Manifest Digital, digital agency Ghana, web development team, our story, company mission">
    <meta name="author" content="Manifest Digital">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/favicon.png') }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="About Us | Manifest Digital">
    <meta property="og:description" content="Discover the story behind Manifest Digital and meet the team transforming businesses across Ghana with innovative digital solutions.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://manifestghana.com/about-us">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="About Us | Manifest Digital">
    <meta name="twitter:description" content="Learn about our mission, values, and the expert team behind Ghana's leading digital solutions agency.">
    
    <title>{{$title}}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   @vite(['resources/css/styles.css', 'resources/js/scripts.js'])
    
    <style>
        /* About Us Page Specific Styles */
        
        /* About Hero Section */
        .about-hero {
            background: linear-gradient(135deg, rgba(255, 34, 0, 0.9), rgba(255, 107, 0, 0.9));
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .about-hero-content {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: 0 auto;
        }

        .about-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .about-hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Section Styles */
        section {
            padding: 5rem 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-align: center;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            text-align: center;
            max-width: 700px;
            margin: 0 auto 3rem;
        }

        /* Story Section */
        .story-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .story-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 1.5rem;
        }

        .highlight-box {
            background: linear-gradient(135deg, rgba(255, 34, 0, 0.05), rgba(255, 107, 0, 0.05));
            border-left: 4px solid #ff2200;
            padding: 2rem;
            margin: 2rem 0;
            border-radius: 8px;
        }

        .highlight-box h3 {
            color: #ff2200;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Mission & Vision */
        .mission-vision-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .mv-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .mv-card:hover {
            transform: translateY(-10px);
        }

        .mv-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .mv-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #ff2200;
        }

        .mv-card p {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.7;
        }

        /* Values Section */
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .value-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
            border-top: 3px solid #ff2200;
        }

        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(255, 34, 0, 0.2);
        }

        .value-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(255, 34, 0, 0.1), rgba(255, 107, 0, 0.1));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: #ff2200;
            font-size: 1.8rem;
        }

        .value-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            color: #333;
        }

        .value-card p {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
        }

        /* Timeline Section */
        .timeline {
            position: relative;
            max-width: 900px;
            margin: 3rem auto;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 3px;
            height: 100%;
            background: linear-gradient(to bottom, #ff2200, #ff6b00);
        }

        .timeline-item {
            display: flex;
            justify-content: flex-start;
            padding: 2rem 0;
            position: relative;
        }

        .timeline-item:nth-child(even) {
            justify-content: flex-end;
        }

        .timeline-content {
            width: 45%;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            position: relative;
        }

        .timeline-year {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.2rem;
            box-shadow: 0 0 0 10px rgba(255, 34, 0, 0.1);
        }

        .timeline-content h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #ff2200;
        }

        .timeline-content p {
            color: #666;
            line-height: 1.6;
        }

        /* Our People Section */
        .people-section {
            padding: 6rem 0;
            background: #fafafa;
        }

        .people-intro {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 4rem;
        }

        .people-intro h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
        }

        .people-intro p {
            font-size: 1.2rem;
            color: #666;
            line-height: 1.6;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }

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

        /* Team Modal Styles */
        .team-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .team-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            transform: translateY(30px);
            transition: transform 0.3s ease;
        }

        .team-modal.active .modal-content {
            transform: translateY(0);
        }

        .modal-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 40px;
            height: 40px;
            border: none;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            color: #666;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .modal-close:hover {
            background: #FF4900;
            color: white;
        }

        .modal-header {
            background: linear-gradient(135deg, #FF4900, #FF6B3D);
            color: white;
            padding: 3rem 3rem 2rem;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .modal-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.2);
            margin: 0 auto 1.5rem;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .modal-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-photo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .modal-name {
            font-size: 2.2rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0 !important;
            line-height: 1.2;
            display: block;
        }

        .modal-role {
            font-size: 1.2rem;
            opacity: 0.9;
            margin: 0 0 1rem 0 !important;
            line-height: 1.4;
            display: block;
        }

        .modal-contact {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .contact-item {
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-body {
            padding: 3rem;
        }

        .modal-section {
            margin-bottom: 3rem;
        }

        .modal-section:last-child {
            margin-bottom: 0;
        }

        .modal-section h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .section-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #FF4900, #FF6B3D);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .bio-text {
            font-size: 1rem;
            color: #666;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .skill-category {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid #FF4900;
        }

        .skill-category h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.8rem;
        }

        .skill-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .skill-list li {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .skill-list li::before {
            content: '▪';
            color: #FF4900;
            font-weight: bold;
        }

        .experience-timeline {
            position: relative;
            padding-left: 2rem;
        }

        .experience-timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #FF4900, #FF6B3D);
        }

        .experience-item {
            position: relative;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .experience-item::before {
            content: '';
            position: absolute;
            left: -1.75rem;
            top: 1.5rem;
            width: 12px;
            height: 12px;
            background: #FF4900;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .experience-period {
            font-size: 0.8rem;
            color: #FF4900;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .experience-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.3rem;
        }

        .experience-company {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.8rem;
        }

        .experience-description {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
        }

        .achievements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .achievement-item {
            background: linear-gradient(135deg, #f8f9fa, #fff);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            text-align: center;
        }

        .achievement-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #FF4900, #FF6B3D);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .achievement-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .achievement-description {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.5;
        }

        /* ===================================
           PHOTO TEAM SECTION STYLES
        =================================== */
        .photo-team-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .photo-team-section .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .photo-team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .photo-team-member {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .photo-team-member:hover {
            transform: translateY(-5px);
        }

        .member-image-container {
            position: relative;
            width: 100%;
            aspect-ratio: 1;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .photo-team-member:hover .member-image-container {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .member-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .photo-team-member:hover .member-image {
            transform: scale(1.05);
        }

        .member-hover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 73, 0, 0.9), rgba(255, 107, 61, 0.9));
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-team-member:hover .member-hover-overlay {
            opacity: 1;
        }

        .member-info-overlay {
            text-align: center;
            color: white;
            transform: translateY(20px);
            transition: transform 0.3s ease 0.1s;
        }

        .photo-team-member:hover .member-info-overlay {
            transform: translateY(0);
        }

        .overlay-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            line-height: 1.2;
        }

        .overlay-role {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0 0 1.5rem 0;
            font-weight: 400;
        }

        .overlay-social {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .overlay-social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .overlay-social-link:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
            color: white;
        }

        /* ===================================
           CIRCLE TEAM SECTION STYLES
        =================================== */
        .circle-team-section {
            padding: 5rem 0;
            background: #ffffff;
        }

        .circle-team-section .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .circle-team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .circle-team-member {
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .circle-team-member:hover {
            transform: translateY(-5px);
        }

        .circle-photo-container {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 4px solid #f8f9fa;
        }

        .circle-team-member:hover .circle-photo-container {
            box-shadow: 0 12px 35px rgba(255, 73, 0, 0.15);
            border-color: #FF4900;
        }

        .circle-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .circle-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 73, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
            font-size: 1.5rem;
        }

        .circle-team-member:hover .circle-overlay {
            opacity: 1;
        }

        .circle-team-member:hover .circle-photo {
            transform: scale(1.1);
        }

        .circle-member-info {
            padding: 0 1rem;
        }

        .circle-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin: 0 0 0.5rem 0;
            line-height: 1.3;
        }

        .circle-role {
            font-size: 1rem;
            color: #666;
            margin: 0 0 1rem 0;
            font-weight: 400;
        }

        .circle-email {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #FF4900;
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background: rgba(255, 73, 0, 0.1);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .circle-email:hover {
            background: rgba(255, 73, 0, 0.15);
            color: #FF4900;
            transform: translateY(-2px);
        }

        .circle-social {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .circle-social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 50%;
            color: #666;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .circle-social-link:hover {
            background: #FF4900;
            color: white;
            transform: translateY(-2px);
            border-color: #FF4900;
            box-shadow: 0 4px 15px rgba(255, 73, 0, 0.3);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .team-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 2rem;
            }

            .modal-content {
                margin: 1rem;
                max-height: 95vh;
            }

            .modal-header {
                padding: 2rem 2rem 1.5rem;
            }

            .modal-photo {
                width: 120px;
                height: 120px;
            }

            .modal-name {
                font-size: 1.8rem;
            }

            .modal-body {
                padding: 2rem 1.5rem;
            }

            .skills-grid {
                grid-template-columns: 1fr;
            }

            .achievements-grid {
                grid-template-columns: 1fr;
            }

            .experience-timeline {
                padding-left: 1.5rem;
            }

            .modal-contact {
                flex-direction: column;
                align-items: center;
            }
        }

        /* Testimonials */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .testimonial-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            position: relative;
        }

        .quote-icon {
            font-size: 3rem;
            color: rgba(255, 34, 0, 0.2);
            position: absolute;
            top: 1rem;
            left: 1.5rem;
        }

        .testimonial-text {
            font-size: 1rem;
            color: #666;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            margin-top: 1rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-info h5 {
            font-weight: 700;
            margin-bottom: 0.2rem;
            color: #333;
        }

        .author-location {
            font-size: 0.9rem;
            color: #ff2200;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .about-hero h1 {
                font-size: 2.5rem;
            }

            .timeline::before {
                left: 30px;
            }

            .timeline-item {
                justify-content: flex-end !important;
                padding-left: 80px;
            }

            .timeline-content {
                width: 100%;
            }

            .timeline-year {
                left: 30px;
            }
        }

        @media (max-width: 768px) {
            .about-hero h1 {
                font-size: 2rem;
            }

            .about-hero p {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .hero-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
  <!-- Initial state setup for preloader -->
    <style>
        .loading .main-content {
            opacity: 0;
            visibility: hidden;
        }
    </style>
      @if ($preloader == 'simple')
        @vite(['resources/css/simple-preloader.css', 'resources/js/simple-preloader.js'])
    @else
        @vite(['resources/css/advanced-preloader.css', 'resources/js/advanced-preloader.js'])
    @endif

</head>
<body class="loading">
    <!-- Reading Tracker Progress Bar -->
    <div class="reading-tracker"></div>
    <x-notification-topbar :style="$notificationStyle" />


    {{-- @if ($preloader == 'simple')
        <x-common.simple-preloader />
    @else
        <x-common.advanced-preloader />
    @endif --}}

    <x-common.header />
  {{$slot}}