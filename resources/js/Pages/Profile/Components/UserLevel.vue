<script setup>
defineProps({
    currentStage: {
        type: Number,
        default: 1
    },
    stageOneStatus: {
        type: Object,
        default: () => ({
            phone: false,
            biometric: false,
            address: false,
            maxTransactions: 3
        })
    },
    stageTwoStatus: {
        type: Object,
        default: () => ({
            phone: false,
            biometric: false,
            address: false,
            maxTransactions: 3
        })
    }
});
</script>

<template>
    <div class="user-level-container bg-white rounded-xl p-4">
        <!-- Stage 1 -->
        <div class="stage-section">
            <div class="stage-header flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Stage 1</h3>
                <span class="status-badge" :class="{ 'confirmed': stageOneStatus.phone && stageOneStatus.biometric && stageOneStatus.address }">
                    {{ stageOneStatus.phone && stageOneStatus.biometric && stageOneStatus.address ? 'confirmed' : 'incomplete' }}
                </span>
            </div>

            <div class="required-info mb-6">
                <h4 class="text-gray-600 mb-3">Required information</h4>
                <div class="verification-list space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="check-icon" :class="{ 'verified': stageOneStatus.phone }">
                            {{ stageOneStatus.phone ? '✓' : '○' }}
                        </div>
                        <span>Phone Number</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="check-icon" :class="{ 'verified': stageOneStatus.biometric }">
                            {{ stageOneStatus.biometric ? '✓' : '○' }}
                        </div>
                        <span>Biometric verification</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="check-icon" :class="{ 'verified': stageOneStatus.address }">
                            {{ stageOneStatus.address ? '✓' : '○' }}
                        </div>
                        <span>Address</span>
                    </div>
                </div>
            </div>

            <div class="facilities">
                <h4 class="text-gray-600 mb-3">Facilities</h4>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="check-icon verified">✓</span>
                        <span>Number of open transactions</span>
                    </div>
                    <span class="text-gray-600">{{ stageOneStatus.maxTransactions }}</span>
                </div>
            </div>
        </div>

        <div class="divider my-6 border-t border-gray-200"></div>

        <!-- Stage 2 -->
        <div class="stage-section">
            <div class="stage-header flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Stage 2</h3>
                <span class="status-badge uncomplet">uncomplet</span>
            </div>

            <div class="required-info mb-6">
                <h4 class="text-gray-600 mb-3">Required information</h4>
                <div class="verification-list space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="check-icon">○</div>
                        <span>Phone Number</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="check-icon">○</div>
                        <span>Biometric verification</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="check-icon">○</div>
                        <span>Address</span>
                    </div>
                </div>
            </div>

            <div class="facilities">
                <h4 class="text-gray-600 mb-3">Facilities</h4>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="check-icon verified">✓</span>
                        <span>Number of open transactions</span>
                    </div>
                    <span class="text-gray-600">{{ stageTwoStatus.maxTransactions }}</span>
                </div>
            </div>

            <button class="w-full mt-6 py-3 bg-primary-60 text-white rounded-lg hover:bg-primary-80 transition-colors">
                Improve Your account to stage 2
            </button>
        </div>
    </div>
</template>

<style scoped>
.user-level-container {
    font-family: -apple-system, system-ui, sans-serif;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 14px;
}

.status-badge.confirmed {
    background-color: #E8F5E9;
    color: #2E7D32;
}

.status-badge.uncomplet {
    background-color: #FFEBEE;
    color: #C62828;
}

.check-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
}

.check-icon.verified {
    color: #2E7D32;
}
</style> 