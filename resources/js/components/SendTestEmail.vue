<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form @submit.prevent="sendTestEmail">
                    <div class="input-group">
                        <label for="type">SMTP type</label>
                        <select name="type" id="type" @change="onTypeChange">
                            <option value="smtp">Predefined SMTP</option>
                            <option value="mailgun">Predefined Mailgun</option>
                            <option value="custom_smtp">Custom SMTP</option>
                            <option value="custom_mailgun">Custom Mailgun</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="to">To</label>
                        <input type="email" name="to" id="to" v-model="to">
                    </div>
                    <div v-if="type === 'custom_smtp'">
                        <div class="input-group">
                            <label for="host">Host</label>
                            <input type="text" name="host" id="host" v-model="host">
                        </div>
                        <div class="input-group">
                            <label for="port">Port</label>
                            <input type="text" name="port" id="port" v-model="port">
                        </div>
                        <div class="input-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" v-model="username">
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="password" v-model="password">
                        </div>
                        <div class="input-group">
                            <label for="encryption">Encryption</label>
                            <input type="text" name="encryption" id="encryption" v-model="encryption">
                        </div>
                        <div class="input-group">
                            <label for="from_name">From name</label>
                            <input type="text" name="from_name" id="from_name" v-model="from_name">
                        </div>
                        <div class="input-group">
                            <label for="from_email">From email</label>
                            <input type="text" name="from_email" id="from_email" v-model="from_email">
                        </div>
                    </div>
                    <div v-else-if="type === 'custom_mailgun'">
                        <div class="input-group">
                            <label for="domain">Domain</label>
                            <input type="text" name="domain" id="domain" v-model="domain">
                        </div>
                        <div class="input-group">
                            <label for="secret">Secret</label>
                            <input type="text" name="secret" id="secret" v-model="secret">
                        </div>
                    </div>
                    <input type="submit" value="Send test email">
                </form>
            </div>
        </div>
    </div>

</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            type: 'smtp',
            to: '',
            host: '',
            port: '',
            username: '',
            password: '',
            encryption: '',
            from_name: '',
            from_email: '',
            domain: '',
            secret: '',
        }
    },
    methods: {
        onTypeChange(event) {
            this.type = event.target.value
        },
        sendTestEmail() {
            axios.post('/api/send-test-email', {
                type: this.type,
                to: this.to,
                host: this.host,
                port: this.port,
                username: this.username,
                password: this.password,
                encryption: this.encryption,
                from_name: this.from_name,
                from_email: this.from_email,
                domain: this.domain,
                secret: this.secret,
            })
        }
    }
}
</script>
<style scoped>

</style>
