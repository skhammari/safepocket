<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const currentStep = ref(0);
const steps = [
    { title: 'Select ID type' },
    { title: 'Front Of National ID Card' },
    { title: 'Back Of National ID Card' },
    { title: 'Biometric Identification' }
];

const idTypes = [
    { id: 'passport', name: 'Passport', description: '150 countries supported' },
    { id: 'drivers_license', name: 'Driver\'s License', description: 'EU, United States' },
    { id: 'national_id', name: 'National ID Card', description: '150+ countries supported' }
];

const nextStep = () => {
    if (currentStep.value < steps.length - 1) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
};

const uploadFiles = {
    idFront: null,
    idBack: null,
    selfie: null
};

const handleFileUpload = (event, type) => {
    const file = event.target.files[0];
    if (file) {
        uploadFiles[type] = file;
    }
};

const uploadIdDocuments = async () => {
    const formData = new FormData();
    formData.append('id_type', selectedIdType.value);
    formData.append('id_front', uploadFiles.idFront);
    formData.append('id_back', uploadFiles.idBack);

    try {
        await axios.post(route('verification.id-documents'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        nextStep();
    } catch (error) {
        console.error('Error uploading documents:', error);
    }
};

const uploadSelfie = async () => {
    const formData = new FormData();
    formData.append('selfie', uploadFiles.selfie);

    try {
        await axios.post(route('verification.selfie'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        emit('close');
    } catch (error) {
        console.error('Error uploading selfie:', error);
    }
};
</script>

<template>
    <div class="biometric-verification bg-white min-h-screen">
        <!-- Header -->
        <div class="header flex items-center justify-between p-4 border-b">
            <button @click="prevStep" class="back-btn text-2xl text-primary-60">‹</button>
            <h1 class="text-xl font-semibold">{{ steps[currentStep].title }}</h1>
            <div class="flex gap-4">
                <button class="text-2xl">🎧</button>
                <button class="text-2xl">🔍</button>
            </div>
        </div>

        <!-- Content -->
        <div class="content p-6">
            <!-- Step 1: ID Type Selection -->
            <div v-if="currentStep === 0" class="id-type-selection">
                <p class="text-gray-600 mb-6">
                    We require a photo of your ... to verify your identity
                </p>
                
                <div class="id-options space-y-4">
                    <button 
                        v-for="type in idTypes" 
                        :key="type.id"
                        class="w-full p-4 flex items-center justify-between bg-colors-natural-9 rounded-xl"
                        @click="nextStep"
                    >
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">{{ type.id === 'passport' ? '📘' : '🪪' }}</span>
                            <div class="text-left">
                                <h3 class="font-semibold">{{ type.name }}</h3>
                                <p class="text-sm text-gray-600">{{ type.description }}</p>
                            </div>
                        </div>
                        <span class="text-xl text-gray-400">›</span>
                    </button>
                </div>
            </div>

            <!-- Step 2: Front ID Photo -->
            <div v-else-if="currentStep === 1" class="id-photo-capture">
                <p class="text-gray-600 mb-4">
                    Take a clear photo of the front of your National ID Card. Camera capture with a mobile device will improve photo quality
                </p>
                
                <div class="camera-frame bg-colors-natural-9 aspect-video rounded-xl mb-4 flex items-center justify-center">
                    <div class="camera-overlay relative">
                        <div class="corner-marks absolute inset-0 border-2 border-primary-60 rounded-lg"></div>
                    </div>
                </div>
                
                <p class="text-center text-sm text-gray-600">Place the front of your ID in the frame</p>
                
                <input 
                    type="file" 
                    accept="image/*"
                    @change="(e) => handleFileUpload(e, 'idFront')"
                    class="hidden"
                    ref="frontIdInput"
                >
                
                <button 
                    @click="$refs.frontIdInput.click()"
                    class="w-full mt-6 py-3 bg-primary-60 text-white rounded-lg hover:bg-primary-80"
                >
                    Take Photo
                </button>
            </div>

            <!-- Step 3: Back ID Photo -->
            <div v-else-if="currentStep === 2" class="id-photo-capture">
                <p class="text-gray-600 mb-4">
                    Take a clear photo of the back of your National ID Card. Camera capture with a mobile device will improve photo quality
                </p>
                
                <div class="camera-frame bg-colors-natural-9 aspect-video rounded-xl mb-4 flex items-center justify-center">
                    <div class="camera-overlay relative">
                        <div class="corner-marks absolute inset-0 border-2 border-primary-60 rounded-lg"></div>
                    </div>
                </div>
                
                <p class="text-center text-sm text-gray-600">Place the back of your ID in the frame</p>
                
                <input 
                    type="file" 
                    accept="image/*"
                    @change="(e) => handleFileUpload(e, 'idBack')"
                    class="hidden"
                    ref="backIdInput"
                >
                
                <button 
                    @click="$refs.backIdInput.click()"
                    class="w-full mt-6 py-3 bg-primary-60 text-white rounded-lg hover:bg-primary-80"
                >
                    Take Photo
                </button>
            </div>

            <!-- Step 4: Biometric Verification -->
            <div v-else-if="currentStep === 3" class="biometric-capture">
                <p class="text-gray-600 mb-4">
                    Take a clear photo of your face in the specified frame and read the following sentence.
                </p>
                
                <div class="camera-frame bg-colors-natural-9 aspect-video rounded-xl mb-4 flex items-center justify-center">
                    <div class="camera-overlay relative">
                        <div class="face-outline w-32 h-32 border-2 border-primary-60 rounded-full"></div>
                    </div>
                </div>
                
                <p class="text-center font-medium mb-6">
                    I am Sarah and I accept the Safe Pocket rules and regulations
                </p>
                
                <input 
                    type="file" 
                    accept="image/*"
                    @change="(e) => handleFileUpload(e, 'selfie')"
                    class="hidden"
                    ref="selfieInput"
                >
                
                <button 
                    @click="$refs.selfieInput.click()"
                    class="w-full py-3 bg-primary-60 text-white rounded-lg hover:bg-primary-80"
                >
                    Start Recording
                </button>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-dots fixed bottom-6 left-0 right-0 flex justify-center gap-2">
            <div 
                v-for="(step, index) in steps" 
                :key="index"
                class="w-2 h-2 rounded-full"
                :class="index === currentStep ? 'bg-primary-60' : 'bg-gray-300'"
            ></div>
        </div>
    </div>
</template>

<style scoped>
.camera-frame {
    min-height: 300px;
}

.camera-overlay {
    width: 80%;
    height: 80%;
}

.corner-marks::before,
.corner-marks::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border: 2px solid #4263EB;
}

.face-outline {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style> 