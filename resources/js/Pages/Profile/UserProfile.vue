<template>
    <div class="profile-container">
        <!-- Header -->
        <div class="header">
            <button @click="router.post('/logout', { preserveScroll: true })" class="back-button">‹</button>
            <h1>Profile</h1>
            <div class="header-actions">
                <button class="header-icon">🎧</button>
                <button class="header-icon">🔍</button>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="profile-info flex items-center flex-row">
            <div class="flex flex-row items-center gap-2">
                <img
                    :src="profileData.avatar"
                    alt="Profile"
                    class="avatar"
                />
                <h2 class="font-semibold">{{ profileData.name }}</h2>
            </div>
            <div class="profile-details">
                <p class="login-info">
                    Last login {{ profileData.lastLogin }}
                    <br />
                    IP : {{ profileData.ip }}
                </p>
            </div>
        </div>

        <!-- Main Settings -->
        <div class="settings-section bg-colors-natural-9 rounded-xl">
            <div class="setting-item">
                <span>User Level</span>
                <div class="setting-value with-arrow">
                    <span>Stage 1</span>
                    <span class="arrow">›</span>
                </div>
            </div>
            <hr class="w-5/6 mx-auto">
            <div class="setting-item">
                <span>Transaction fees</span>
                <span class="setting-value">base</span>
            </div>
            <hr class="w-5/6 mx-auto">
            <div class="setting-item">
                <div class="setting-label">
                    <span>Bank information</span>
                    <p class="setting-sublabel">Bank information for depositing and withdrawing currency</p>
                </div>
                <span class="arrow">›</span>
            </div>
            <hr class="w-5/6 mx-auto">
            <div class="setting-item">
                <span>Setting</span>
                <span class="arrow">›</span>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="contact-section bg-colors-natural-9 rounded-xl">
            <div class="setting-item">
                <span>Phone Number</span>
                <div class="setting-value">
                    <span>{{ profileData.phone }}</span>
                    <button class="edit-button">✎</button>
                </div>
            </div>

            <div class="setting-item">
                <span>Address</span>
                <div class="setting-value">
                    <span>{{ profileData.address }}</span>
                    <button class="edit-button">✎</button>
                </div>
            </div>

            <div class="setting-item">
                <span>Biometric verification</span>
                <div class="check-icon success">✓</div>
            </div>

            <!-- Verification Status -->
            <div class="verification-section">
                <div class="verification-item">
                    <div class="check-icon">✓</div>
                    <span>You verified your account</span>
                </div>
            </div>
        </div>



        <!-- Security -->
        <div class="security-section bg-colors-natural-9 rounded-xl p-3">
            <h3>Security</h3>
            <div class="setting-item">
                <span>Email</span>
                <span class="setting-value">{{ profileData.email }}</span>
            </div>
            <hr class="w-5/6 mx-auto">
            <div class="setting-item">
                <span>Password</span>
                <span class="arrow">›</span>
            </div>
        </div>

        <!-- Transaction Limits -->
        <div class="limits-section bg-colors-natural-9 rounded-xl p-3">
            <div class="limits-header">
                <h3>Daily limit report for level 1 transaction</h3>
                <p class="limits-sublabel">The transaction limit is calculated based on the user level</p>
            </div>
            <div class="limits-info">
                <div class="restriction-item">
                    <span class="dot"></span>
                    <span>Restrictions on transactions</span>
                </div>
                <div class="active-transactions">1 Active transactions</div>
            </div>
            <button class="upgrade-button">
                User level upgrade
            </button>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'


const profileData = reactive({
    name: 'Saeed',
    avatar: 'https://via.placeholder.com/64',
    lastLogin: '09-09-20',
    ip: '87.28.23.112',
    phone: '01765432676',
    address: 'Estonia',
    email: 'sar***@gmail.com'
})
</script>

<style scoped>
.profile-container {
    padding: 16px;
    background: #fff;
    font-family: -apple-system, system-ui, sans-serif;
    max-width: 500px;
    margin: 0 auto;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.back-button {
    font-size: 24px;
    color: #4263EB;
    border: none;
    background: none;
    padding: 0;
}

.header h1 {
    font-size: 20px;
    font-weight: 500;
}

.header-actions {
    display: flex;
    gap: 12px;
}

.header-icon {
    border: none;
    background: none;
    font-size: 20px;
}

.profile-info {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}

.avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
}

.profile-details h2 {
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 4px;
}

.login-info {
    color: #666;
    font-size: 14px;
    line-height: 1.4;
}

.settings-section,
.contact-section,
.security-section {
    margin-bottom: 24px;
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border-radius: 8px;
    margin: 6px 0;
}

.setting-value {
    color: #666;
    display: flex;
    align-items: center;
    gap: 8px;
}

.setting-label {
    display: flex;
    flex-direction: column;
}

.setting-sublabel {
    color: #666;
    font-size: 14px;
    margin-top: 4px;
}

.arrow {
    color: #666;
    font-size: 18px;
}

.edit-button {
    border: none;
    background: none;
    color: #666;
    padding: 0;
    font-size: 16px;
}

.verification-section {
    background: #E8F5E9;
    padding: 16px;
    border-radius: 8px;
    margin: 16px;
}

.verification-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.verification-item:last-child {
    margin-bottom: 0;
}

.check-icon {
    color: #2E7D32;
}

.check-icon.success {
    margin-left: auto;
}

.security-section h3,
.limits-section h3 {
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 16px;
}

.limits-sublabel {
    color: #666;
    font-size: 14px;
    margin-top: 4px;
    margin-bottom: 16px;
}

.restriction-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.dot {
    width: 8px;
    height: 8px;
    background: #1A237E;
    border-radius: 50%;
}

.active-transactions {
    margin-bottom: 16px;
}

.upgrade-button {
    width: 100%;
    padding: 14px;
    border: 1px solid #4263EB;
    border-radius: 8px;
    color: #4263EB;
    background: none;
    font-size: 16px;
    cursor: pointer;
}
</style>
