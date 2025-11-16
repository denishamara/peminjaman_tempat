# 🎨 Modern Main Content Documentation

## 📋 Overview
Sistem main content area dengan desain modern menggunakan glass morphism, gradient effects, dan animasi halus.

## ✨ Fitur Utama

### 1. **Glass Card Effect**
```html
<div class="glass-card">
    <!-- Content here -->
</div>
```
- Background blur dengan transparency
- Border subtle white
- Shadow multi-layer
- Hover effect dengan lift animation

### 2. **Stats Cards**
```html
<div class="stats-card">
    <div class="icon-box icon-box-primary">
        <i class="fas fa-users"></i>
    </div>
    <h3>1,234</h3>
    <p>Total Pengguna</p>
</div>
```

**Icon Box Variants:**
- `icon-box-primary` - Purple gradient
- `icon-box-success` - Green gradient
- `icon-box-warning` - Orange gradient
- `icon-box-danger` - Red gradient
- `icon-box-info` - Blue gradient

### 3. **Modern Table**
```html
<table class="table table-modern">
    <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Data 1</td>
            <td>Data 2</td>
        </tr>
    </tbody>
</table>
```
- Gradient header (purple)
- Hover effect pada rows
- Rounded corners
- Glass effect background

### 4. **Action Buttons**
```html
<!-- Primary -->
<button class="action-btn action-btn-primary">
    <i class="fas fa-plus"></i> Tambah Data
</button>

<!-- Success -->
<button class="action-btn action-btn-success">
    <i class="fas fa-check"></i> Approve
</button>

<!-- Danger -->
<button class="action-btn action-btn-danger">
    <i class="fas fa-trash"></i> Hapus
</button>
```

### 5. **Modern Badges**
```html
<span class="badge-modern badge-success">
    <i class="fas fa-check-circle me-1"></i>Diterima
</span>

<span class="badge-modern badge-warning">
    <i class="fas fa-clock me-1"></i>Proses
</span>

<span class="badge-modern badge-danger">
    <i class="fas fa-times-circle me-1"></i>Ditolak
</span>
```

### 6. **Page Header**
```html
<div class="page-header">
    <h1 class="gradient-text">
        <i class="fas fa-th-large me-2"></i>
        Dashboard Modern
    </h1>
    <nav class="breadcrumb-modern">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <i class="fas fa-home me-1"></i>Home
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
```

### 7. **Empty State**
```html
<div class="empty-state">
    <div class="empty-state-icon">
        <i class="fas fa-inbox"></i>
    </div>
    <h3>Belum Ada Data</h3>
    <p>Belum ada aktivitas yang tercatat</p>
    <button class="action-btn action-btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Data Baru
    </button>
</div>
```

## 🎯 Layout Structure

```html
<body class="modern-dashboard">
    <?= view('layouts/sidebar') ?>
    
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">...</div>
        
        <!-- Stats Cards -->
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="stats-card">...</div>
            </div>
        </div>
        
        <!-- Content Cards -->
        <div class="glass-card">...</div>
    </div>
</body>
```

## 📱 Responsive Breakpoints

- **Desktop (>992px)**: Full width dengan margin-left 260px
- **Tablet (≤992px)**: Full width, no margin, margin-top 65px
- **Mobile (≤576px)**: Reduced padding, smaller cards

## 🎨 Color Scheme

### Gradients:
- **Primary**: `#667eea → #764ba2` (Purple)
- **Success**: `#10b981 → #059669` (Green)
- **Warning**: `#f59e0b → #d97706` (Orange)
- **Danger**: `#ef4444 → #dc2626` (Red)
- **Info**: `#3b82f6 → #2563eb` (Blue)

### Glass Effect:
- Background: `rgba(255, 255, 255, 0.95)`
- Backdrop blur: `20px`
- Border: `rgba(255, 255, 255, 0.3)`

## 🚀 Animation Features

1. **Fade In on Scroll**: Cards animate when entering viewport
2. **Hover Effects**: Lift animation (translateY -4px)
3. **Button Shimmer**: Shine effect on hover
4. **Table Row Hover**: Scale and background change
5. **Stats Counter**: Optional counting animation

## 📦 Dependencies

- **Tailwind CSS 3.x**: Utility classes
- **Bootstrap 5.3**: Grid system & components
- **FontAwesome 6.4**: Icons
- **Custom CSS**: style.css (updated)

## 💡 Usage Example

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Include all CSS dependencies -->
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body class="modern-dashboard">
    <?= view('layouts/sidebar') ?>
    
    <div class="main-content">
        <div class="glass-card">
            <h3 class="gradient-text">My Content</h3>
            <p>Content goes here...</p>
        </div>
    </div>
</body>
</html>
```

## 🎯 Best Practices

1. ✅ Always use `class="modern-dashboard"` on body
2. ✅ Wrap content in `glass-card` for consistency
3. ✅ Use gradient-text for headings
4. ✅ Include icon-box in stats cards
5. ✅ Add loading animations for better UX
6. ✅ Test responsive behavior on all breakpoints

## 📝 Notes

- Main content automatically adjusts for sidebar
- All animations use hardware acceleration (transform)
- Glass effect works best on modern browsers
- Fallback solid colors for older browsers
- Touch-optimized for mobile devices

---

Created with 💜 for modern, beautiful UI/UX
