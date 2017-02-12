import { NgForm } from '@angular/forms';
import { Broadcaster } from './../services/broadcaster.service';
import { CommonService } from './../services/common.service';

import {
  Component,
  OnInit
} from '@angular/core';

import { AppState } from '../app.service';

@Component({
  selector: 'login',
  styleUrls: [ './login.component.scss' ],
  templateUrl: './login.component.html'
})
export class LoginComponent implements OnInit {

  private showModal: boolean = false;
  private modalType: string = 'login'; // register or invite
  private showPasswordError: boolean = false;
  private showUsernameError: boolean = false;
  private showAcceptTerms: boolean = false;
  private showEmailError: boolean = false;
  private errorMessage: string = '';
  private successMessage: string = '';
  private registerFormDisabled: boolean = false;

  constructor(
    public appState: AppState,
    private commonService: CommonService,
    private broadcaster: Broadcaster
  ) {}

  public ngOnInit() {
    // yet to be written
    this.listenToEvents();
  }

  public closeModal() {
    this.showModal = false;
  }

  public switchTo(modalType: string) {
    this.modalType = modalType;
  }

  public onSubmit(f: NgForm) {
    // console.log(f.value);  // { first: '', last: '' }
    // console.log(f.valid);  // false
    this.resetErrors();
    let fields: any = f.value;
    if (fields.pw1 !== fields.pw2) {
      this.showPasswordError = true;
      this.errorMessage = 'Passwords don\'t match';
      return;
    }
    if (!fields.terms) {
      this.showAcceptTerms = true;
      this.errorMessage = 'Please accept our terms and condition.';
      return;
    }
    this.registerFormDisabled = true;
    const md5 = require('js-md5');
    let params = {
      firstname: fields.userFirstName,
      lastname: fields.userLastName,
      username: fields.userName,
      email: fields.userEmail,
      password: md5(fields.pw1),
    };
    this.commonService.createUser(params)
      .then((resp) => {
        this.registerFormDisabled = false;
        console.log(resp);
        if (resp.status === 506) {
          this.showUsernameError = true;
          this.errorMessage = resp.message;
        } else if (resp.status === 507) {
          this.showEmailError = true;
          this.errorMessage = resp.message;
        } else {
          f.reset();
          this.successMessage = resp.message;
          setTimeout(() => {
            this.resetErrors();
            this.modalType = 'login';
          }, 3000);
        }
      });
  }

  private resetErrors() {
    this.showPasswordError = false;
    this.showUsernameError = false;
    this.showAcceptTerms = false;
    this.showEmailError = false;
    this.errorMessage = '';
    this.successMessage = '';
  }

  private listenToEvents() {
    this.broadcaster.on<string>('login_modal')
      .subscribe((message) => {
        if (message === 'open') {
          this.showModal = true;
        }
      });
  }

}
