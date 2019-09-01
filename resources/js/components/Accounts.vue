<template>
    <div>
    <v-row>
        <v-col>

            <v-card>
                <v-card-title>
                    <v-text-field
                    v-model="search"
                    append-icon="search"
                    single-line
                    hide-details
                    label="Search"
                    color="success"
                    >


                    </v-text-field>


                </v-card-title>

            <v-data-table
                :headers="headers"
                :items="accounts"
                :items-per-page=20
                :search="search"
                :loading='loading'

                class="elevation-1">
                <template v-slot:item.fname="{ item }">
                    <router-link :to="'/account/'+item.id">{{item.fname}}</router-link>
                </template>

                <template v-slot:item.passport="{ item }">
                   <v-avatar avatar="36px" style="margin:16px;">
                       <img
                           v-bind:alt="item.fname"
                           :src="item.passport ? item.passport : imgsrc"
                       >

                   </v-avatar>
                </template>
            </v-data-table>
            </v-card>

        </v-col>
    </v-row>

        <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="90%">

                <v-card>
                    <v-card-title class="headline green--text darken-4">Create New Account</v-card-title>
                    <v-card-text>
                        <v-form
                            v-model="formValid"
                            ref="accountForm"
                            enctype="multipart/form-data"
                        >
                    <v-container>
                        <v-row align="center">


                        <v-col cols="12" sm="4">
                            <v-select
                                :items="titles"
                                label="Title"
                                cache-items
                               prepend-icon="mdi-check"
                                color="success"
                                item-color="success"
                                required
                                :rules="titleRules"
                                v-model="title"

                            >

                            </v-select>

                        </v-col>

                        <v-col cols="12" sm="4">
                            <v-text-field
                                label="First Name"
                               prepend-icon="person"
                                color="success"
                                required
                                :rules="nameRules"
                                v-model="fname"

                            >

                            </v-text-field>

                        </v-col>

                        <v-col cols="12" sm="4">
                            <v-text-field
                                label="Last Name"
                               prepend-icon="person"
                                color="success"
                                required
                                :rules="nameRules"
                                v-model="lname"

                            >

                            </v-text-field>

                        </v-col>


                        <v-col cols="12" sm="4">
                            <v-select
                                :items="sexList"
                                label="Sex"
                                cache-items
                                prepend-icon="mdi-gender-male-female-variant"
                                color="success"
                                item-color="success"
                                required
                                :rules="sexRules"
                                v-model="sex"

                            >

                            </v-select>

                        </v-col>
                        <v-col cols="12" sm="4">
                            <v-text-field
                                label="Phone Number"
                                prepend-icon="phone"
                                color="success"
                                required
                                :rules="phoneRules"
                                v-model="phone"


                            >

                            </v-text-field>

                        </v-col>


                        <v-col cols="12" sm="4">
                            <v-text-field
                                label="Occupation"
                                prepend-icon="mdi-briefcase"
                                color="success"
                                required
                                :rules="occupationRules"
                                v-model="occupation"


                            >

                            </v-text-field>

                        </v-col>

                            <v-col cols="12" sm="6">
                            <v-text-field
                                label="Email Address"
                                prepend-icon="mdi-at"
                                color="success"
                                required
                                :rules="emailRules"
                                v-model="email"



                            >

                            </v-text-field>

                        </v-col>


                        <v-col cols="12" sm="6">
                            <v-textarea
                                name="'address"
                                label="Address"
                                prepend-icon="mdi-map-marker"
                                color="success"
                                required
                                value=""
                                hint="Permanent/Residential Address"
                                :rules="addressRules"
                                v-model="address"


                            >

                            </v-textarea>

                        </v-col>


                        <v-col cols="12" sm="8">
                            <v-text-field
                                label="Hometown"
                                prepend-icon="map"
                                color="success"
                                required
                                :rules="hometownRules"
                                v-model="hometown"
                            >

                            </v-text-field>

                        </v-col>


                        <v-col cols="12" sm="4">
                            <v-dialog
                                ref="dialog"
                                v-model="dobmodal"
                                :return-value.sync="dob"
                                persistent
                                full-width
                                width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="dob"
                                        label="Select Birth Date"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                        :rules="dobRules"
                                    >

                                    </v-text-field>
                                </template>
                                <v-date-picker v-model="dob" scrollable>
                                    <div class="flex-grow-1"></div>
                                    <v-btn text color="success" @click="dobmodal = false">Cancel</v-btn>
                                    <v-btn text color="success" @click="$refs.dialog.save(dob)">OK</v-btn>
                                </v-date-picker>
                            </v-dialog>


                        </v-col>

                            <v-col cols="12" sm="4">
                            <v-text-field
                                label="Bank Name"
                                prepend-icon="mdi-bank"
                                color="success"
                                required
                                :rules="bankRules"
                                v-model="bank"
                            >

                            </v-text-field>

                        </v-col>

                            <v-col cols="12" sm="4">
                            <v-text-field
                                label="Account Number"
                                prepend-icon="mdi-account-details"
                                color="success"
                                required
                                :rules="accnoRules"
                                v-model="accno"

                            >

                            </v-text-field>

                        </v-col>
                            <v-img
                                :src="previewURL"
                                :lazy-src="imgsrc"
                                aspect-ratio="1"
                                class="grey lighten-2"
                                max-width="500"
                                max-height="300"
                            >

                                    <v-row
                                        class="fill-height ma-0"
                                        align="center"
                                        justify="center"
                                    >
                                        <v-progress-circular v-if="imageLoading" indeterminate color="green darken-5"></v-progress-circular>
                                    </v-row>

                            </v-img>


                            <v-btn
                                color="green darken-4"
                                text
                                @click="selectPass"
                            >Select Passport Photo</v-btn>
                            <small v-if="imgSizeError" class="red--text align-self-end">Error: Image size should be less than 500kb</small>
                    <input accept="image/png, image/jpeg, image/bmp" style="display:none" id="filepass" type="file" v-on:change="passChange" >

                    </v-row>
                    </v-container>
                        </v-form>

                        </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="red darken-1" text @click="dialog = false">Cancel</v-btn>
                        <v-btn color="green darken-4" text @click="createAccount">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>

        <v-btn v-if="!dialog" @click="showAddDialog" class="add-fab" color="green darken-4 white--text" rounded >
            New Account <v-icon>mdi-plus</v-icon>

        </v-btn>

        <v-overlay
            :value="progress"
            :absolute="absolute"
            :light="light"
            :z-index="zindex"

        >

            <v-progress-circular
                :size="70"
                :width="4"
                color="white"
                indeterminate
            ></v-progress-circular>

        </v-overlay>



        <v-row justify="center">
            <v-dialog v-model="Errordialog" max-width="40%">

                <v-card>
                    <v-card-title class="headline red--text">Something is not right!</v-card-title>
                    <v-card-text>
                        <h4 color="'red--text">
                            <v-icon color="red--text">warning</v-icon> Could not create Account please make sure E-mail,
                            Phone number and Account number you entered are unique.
                        </h4>
                        <h4  color="'red--text">If it persist please check your network or contact Support</h4>

                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="green darken-1" text @click="Errordialog = false">Close</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>


        <v-row justify="center">
            <v-dialog v-model="noPassDlg" max-width="40%">

                <v-card>
                    <v-card-title class="headline red--text">Passport Photo Not Selected</v-card-title>
                    <v-card-text>
                        <h4 color="'red--text">
                            <v-icon color="red--text">warning</v-icon> The passport Picture is a required field
                        </h4>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="green darken-1" text @click="noPassDlg = false">Okay</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <v-row justify="center">
            <v-dialog v-model="netDlg" max-width="40%">

                <v-card>
                    <v-card-title class="headline red--text">Network Error</v-card-title>
                    <v-card-text>
                        <h4 color="'red--text">
                            <v-icon color="red--text">warning</v-icon> Could not reach the server, please check your network and try again
                        </h4>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="green darken-1" text @click="getAccounts">Retry</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>

</template>


<script>

    export default {

        data(){
            return {
                netDlg:false,
                imageLoading:false,
                light:true,
                absolute:false,
                zindex:999,
                progress:false,
                Errordialog:false,
                headers: [
                    {
                        text: 'Photo',
                        align: 'left',
                        sortable: false,
                        value: 'passport',
                    },
                    { text: 'First Name', value: 'fname' },
                    { text: 'Last Name', value: 'lname' },
                    { text: 'Sex', value: 'sex' },
                    { text: 'Birth Date', value: 'dob' },
                    { text: 'Phone Number', value: 'phone' },
                    { text: 'E-Mail', value: 'email' },
                    { text: 'Bank Name', value: 'bank' },
                    { text: 'Account No.', value: 'accno' },

                ],
            imgsrc:"/images/avatar.png",
            previewURL:"/images/avatar.png",
                accounts : [],
                search:'',
                loading:true,
                dialog:false,
                titles:['Mr.','Miss','Mrs','Dr.','HE','Hon'],
                sexList:['Male','Female','None'],
                formValid:true,
                passportrules: [
                    value => !value || value.size < 500000 || 'Picture size should be less than 500kb!'
                ],
                fname:'',
                lname:'',
                nameRules: [
                    v => !!v || 'Name is required',
                ],
                sex:'',
                sexRules: [
                    v => !!v || 'Sex is required',
                ],
                hometown:'',
                hometownRules: [
                    v => !!v || 'Hometown is required',
                ],
                dob:'',
                dobRules: [
                    v => !!v || 'dob is required',
                ],
                address:'',
                addressRules: [
                    v => !!v || 'Address is required',
                ],
                phone:'',
                phoneRules: [
                    v => !!v || 'Phone Number is required',

                ],
                bank:'',
                bankRules: [
                    v => !!v || 'Bank Name is required',
                ],
                accno:'',
                accnoRules: [
                    v => !!v || 'A valid account number is required',
                ],
                occupation:'',
                occupationRules: [
                    v => !!v || 'Occupation is required',
                ],
                passport:'',
                email:'',
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
                title:'',
                titleRules: [
                    v => !!v || 'Title is required',
                ],
                menu: false,
                dobmodal: false,
                menu2: false,
                imgSizeError:false,
                noPassDlg:false

            }


        },
        mounted() {

        this.getAccounts();


        },


        methods:{

            clearForm(){
                this.fname='';
                this.lname='';
                this.passport='';
                this.address='';
                this.phone='';
                this.email='';
                this.dob='';
                this.bank='';
                this.accno='';
                this.occupation='';
                this.hometown='';
                this.sex='';
                this.title='';
                this.previewURL = this.imgsrc;
            },

            selectPass(){
                let pass = document.getElementById('filepass');
                pass.click();
            },

            passChange(e){

                this.imageLoading = true;
              this.passport = e.target.files[0];
              if(this.passport.size<532598){
                this.imgSizeError = false;
              const fr = new FileReader();
              let photo = fr.readAsDataURL(this.passport);
              fr.onload = ()=>{

                this.previewURL = fr.result;
                this.imageLoading=false;
              }
              }else{


                  this.imgSizeError=true;
              }
            },

        getAccounts(){
                this.netDlg=false;
            fetch('./api/accounts')
                .then(res=>res.json())
                .then(res=>{
                   this.accounts = res;
                   this.loading=false;
                }).catch(()=>{

                this.netDlg = true;
            });

        },
            showAddDialog(){
            this.dialog=true;
            },
            createAccount(){


                this.validateForm();
        if(this.formValid){
            if(!this.passport){
                this.noPassDlg = true;
            }else{


            this.progress=true;
                let fd = new FormData();
                fd.append('fname',this.fname);
                fd.append('lname',this.lname);
                fd.append('sex',this.sex);
                fd.append('hometown',this.hometown);
                fd.append('dob',this.dob);
                fd.append('address',this.address);
                fd.append('phone',this.phone);
                fd.append('accno',this.accno);
                fd.append('occupation',this.occupation);
                fd.append('passport',this.passport);
                fd.append('email',this.email);
                fd.append('title',this.title);
                fd.append('bank',this.bank);

                fetch('./api/createaccount',{
                   method:'POST',
                   body: fd

                })
                    .then(res=>res.json())
                    .then(res=>{
                       this.accounts.push(res);
                       this.clearForm();
                       this.dialog=false;
                       this.progress=false;
                    }).catch(()=>{

                        this.progress=false;
                        this.Errordialog=true;

            });

        }}
            },

            validateForm () {
                if (this.$refs.accountForm.validate()) {
                    this.formValid = true
                }

            }

            },



    }



</script>
<style>
    .add-fab{

        position: fixed;

        bottom: 70px;
        right: 20px;
    ;

    }
</style>
