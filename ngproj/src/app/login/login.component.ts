import { Router } from '@angular/router';
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

  public showModal: boolean = false;
  public modalType: string = 'login'; // register or invite
  public showPasswordError: boolean = false;
  public showUsernameError: boolean = false;
  public showAcceptTerms: boolean = false;
  public showEmailError: boolean = false;
  public showCodeError: boolean = false;
  public errorMessage: string = '';
  public successMessage: string = '';
  public registerFormDisabled: boolean = false;
  public cpType: string = 'request-code';
  public username: string = '';

  constructor(
    public appState: AppState,
    private commonService: CommonService,
    private broadcaster: Broadcaster,
    private router: Router
  ) {}

  public ngOnInit() {
    // yet to be written
    this.listenToEvents();
  }

  public closeModal() {
    this.showModal = false;
    setTimeout(() => this.modalType = 'login', 600);
  }

  public switchTo(modalType: string) {
    this.cpType = 'request-code';
    this.modalType = modalType;
  }

  public onLoginSubmit(f: NgForm) {
    console.log(f.value);
    this.registerFormDisabled = true;
    this.resetErrors();
    let fields: any = f.value;
    this.commonService.login(fields)
      .then((resp) => {
        console.log(resp);
        this.registerFormDisabled = false;
        if (resp.status === 509) {
          this.showPasswordError = true;
          this.errorMessage = resp.message;
        } else if (resp.status === 508) {
          this.showEmailError = true;
          this.errorMessage = resp.message;
        } else {
          f.reset();
          this.successMessage = resp.message;
          this.router.navigate([resp.data.username]);
          this.closeModal();
        }
      });
  }

  public onRegisterSubmit(f: NgForm) {
    // console.log(f.value);  // { first: '', last: '' }
    // console.log(f.valid);  // false
    this.resetErrors();
    let fields: any = f.value;
    if (!fields.captcha) {
      this.errorMessage = 'Please verify that you are not a robot.';
      return;
    }

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

  public onInviteSubmit(f: NgForm) {
    // ToDo

    this.resetErrors();
    this.showEmailError = true;
    this.errorMessage = 'There is some problem';
  }

  public onChangePassword(f: NgForm): void {
    // Change password logic
    let fields: any = f.value;
    console.log(fields);
    this.resetErrors();
    if (this.cpType === 'request-code') {
      this.username = fields.username;
      this.registerFormDisabled = true;
      this.commonService.requestResetPassword(fields)
      .then((resp) => {
        this.registerFormDisabled = false;
        if (resp.status === 200) {
          this.successMessage = resp.message;
          this.cpType = 'reset-password';
          setTimeout(() => {
            this.successMessage = '';
          }, 3000);
        } else {
          this.errorMessage = resp.message;
          this.showEmailError = true;
        }
      });
    } else {
      if (!fields.captcha) {
        this.errorMessage = 'Please verify that you are not a robot.';
        return;
      }
      if (fields.pw1 !== fields.pw2) {
        this.showPasswordError = true;
        this.errorMessage = 'Passwords don\'t match';
        return;
      }
      const md5 = require('js-md5');
      let params = {
        username: this.username,
        password: md5(fields.pw1),
        resetcode: fields.resetcode
      };

      this.registerFormDisabled = true;
      // Reset password
      this.commonService.changePassword(params)
        .then((resp) => {
          this.registerFormDisabled = false;
          if (resp.status === 200) {
            this.successMessage = resp.message;
            setTimeout(() => {
              this.successMessage = '';
              this.cpType = 'request-code';
              this.modalType = 'login';
            });
          } else if (resp.status === 504) {
            this.errorMessage = resp.message;
            this.showCodeError = true;
          }
        });
    }
  }

  private resetErrors() {
    this.showPasswordError = false;
    this.showUsernameError = false;
    this.showAcceptTerms = false;
    this.showEmailError = false;
    this.showCodeError = false;
    this.errorMessage = '';
    this.successMessage = '';
  }

  private listenToEvents() {
    this.broadcaster.on<string>('login_modal')
      .subscribe((message: any) => {
        this.modalType = message.type;
        if (message.state === 'open') {
          this.showModal = true;
        }
      });
  }

}
