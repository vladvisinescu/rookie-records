<template>
    <ConfirmModal :color="'red'" :open="deletesAddress.modal" :data="{ address_id: deletesAddress.id }" @confirm="removeAddress" @cancel="deletesAddress.modal = false">
        <template v-slot:icon>
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </template>
        <template v-slot:title>Are you sure?</template>
        <template v-slot:cta>Delete</template>
    </ConfirmModal>
    <div class="flex flex-col gap-y-6">
        <div class="mb-4">
            <h1 class="text-2xl text-gray-600">Profile</h1>
        </div>
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
            <div class="sm:col-span-2">
                <h3 class="text-lg leading-6 font-bold text-gray-700">Personal Details</h3>
            </div>
            <form class="col-span-4" @submit.prevent="updateUser">
                <div class="overflow-hidden shadow rounded-lg">
                    <div class="bg-white px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">
                                    First name <span v-if="errors.first_name" v-html="errors.first_name[0]" class="text-xs font-bold uppercase text-red-400"></span>
                                </label>
                                <div class="mt-1">
                                    <input
                                        v-model="user.first_name"
                                        type="text"
                                        name="first_name"
                                        id="first_name"
                                        autocomplete="given-name"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">
                                    Last name <span v-if="errors.last_name" v-html="errors.last_name[0]" class="text-xs font-bold uppercase text-red-400"></span>
                                </label>
                                <div class="mt-1">
                                    <input
                                        v-model="user.last_name"
                                        type="text"
                                        name="last_name"
                                        id="last_name"
                                        autocomplete="family-name"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email address
                                </label>
                                <div class="mt-1">
                                    <input
                                        disabled="disabled"
                                        v-model="user.email"
                                        id="email"
                                        name="email"
                                        type="email"
                                        autocomplete="email"
                                        class="bg-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Phone <span v-if="errors.phone" v-html="errors.phone[0]" class="text-xs font-bold uppercase text-red-400"></span>
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">+44</span>
                                    </div>
                                    <input
                                        v-model="user.phone"
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-16 sm:pl-14 sm:text-sm border-gray-300 rounded-md"
                                        placeholder="07xxx xxxxxx" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center bg-gray-100 md:px-4 md:py-2">
                        <div class="px-4">
                            <p v-if="updatesUser.result" class="flex items-center text-sm" :class="updatesUser.success ? 'text-green-400' : 'text-red-400'">
                                <span v-if="updatesUser.success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span v-else>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span v-text="updatesUser.result" class="inline-flex ml-2"></span>
                            </p>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center uppercase font-bold md:normal-case md:font-normal text-md md:text-base border border-transparent text-sm leading-4 font-medium rounded-br-lg md:rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none md:focus:ring ring-gray-400">
                                <span v-if="updatesUser.loading"  class="inline-flex px-4 py-4 md:px-3 md:py-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                <span v-else class="inline-flex px-4 py-4 md:px-3 md:py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="inline-flex pr-4 py-4 md:pr-3 md:py-2">Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
            <div class="sm:col-span-2">
                <h3 class="text-lg leading-6 font-bold text-gray-700">Addresses</h3>
            </div>
            <div class="col-span-4">
                <div class="bg-white shadow overflow-hidden rounded" v-if="hasAddresses">
                    <ul class="divide-y divide-gray-200">
                        <li v-for="address in addresses" :key="address.id" class="px-4 py-4 sm:px-6">
                            <div class="flex justify-between">
                                <div class="flex flex-col w-3/4">
                                    <span v-text="address.address_1" class="font-bold font-lg"></span>
                                    <span v-text="address.address_2" class="text-sm"></span>
                                    <p>
                                        <span v-text="address.town" class="text-sm"></span>,
                                        <span v-text="address.county" class="text-sm"></span>
                                    </p>
                                    <span v-text="address.country" class="text-sm"></span>
                                </div>
                                <div class="flex items-center w-1/4">
                                    <ul class="flex-grow">
                                        <li v-if="!address.default">
                                            <a href="#" @click.prevent="makeAddressDefault(address)">
                                                <CheckIcon class="text-blue-700 h-3 w-3 inline-flex mr-2" />
                                                <span class="text-xs font-bold text-blue-400">Make default</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" @click.prevent="deletesAddress = { modal: true, id: address.id }">
                                                <TrashIcon class="text-red-700 h-3 w-3 inline-flex mr-2" />
                                                <span class="text-xs font-bold text-red-400">Delete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <a @click.prevent="createsNewAddress = !createsNewAddress" href="javascript:;" class="inline-flex text-gray-500 text-sm cursor-pointer pt-4" v-if="hasAddresses">
                    <svg class="inline-flex h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path v-if="!createsNewAddress" fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        <path v-else fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span v-text="createsNewAddress ? 'Hide' : 'Add address'"></span>
                </a>

                <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"

                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95">
                    <AddressForm v-show="!hasAddresses || createsNewAddress" @added="createsNewAddress = false" />
                </transition>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'
import AddressForm from "../User/Shop/AddressForm";
import ConfirmModal from "../Bits/modals/ConfirmModal";

import { CheckIcon, MinusSmIcon, TrashIcon } from '@heroicons/vue/solid'

export default {

    components: {
        AddressForm, ConfirmModal,
        CheckIcon, TrashIcon, MinusSmIcon
    },

    data() {
        return {
            createsNewAddress: false,
            deletesAddress: {
                modal: false,
                id: null
            },
            updatesUser: {
                result: null,
                success: false,
                loading: false
            }
        }
    },

    computed: {
        ...mapGetters({
            user: 'user/getUser',
            addresses: 'address/allAddresses',
            errors: 'user/getErrors'
        }),

        hasAddresses() {
            return _.size(this.addresses) > 0
        }
    },

    created() {
        this.$store.dispatch('address/getAddresses')
    },

    methods: {

        makeAddressDefault(address) {
            this.$store.dispatch('address/updateAddress', { ...address, default: true }).then(response => {
                this.$store.dispatch('address/getAddresses')
            })
        },

        removeAddress({ address_id }) {
            this.$store.dispatch('address/removeAddress', address_id).then(() => {
                this.$store.dispatch('address/getAddresses')
                this.deletesAddress.modal = false
            })
        },

        updateUser() {
            this.updatesUser.loading = true
            this.$store.dispatch('user/updateUser', this.user).then(response => {
                this.updatesUser.result = 'Changes saved.';
                this.updatesUser.success = true;
                this.updatesUser.loading = false;
            }).catch(error => {
                this.updatesUser.result = 'Please review the information you entered.';
                this.updatesUser.success = false;
                this.updatesUser.loading = false;
            })
        }
    }
}
</script>
