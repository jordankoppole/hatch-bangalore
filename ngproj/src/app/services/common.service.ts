import { Headers, Http } from '@angular/http';
import { Injectable } from '@angular/core';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class CommonService {
  private headers = new Headers(
    {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*'
    }
  );

  private token = 'Len3MwR63n5vf7hEiWtA3piRYwQ1EmlXFm2ThIjVGEZFpoWKsah0HCwsRHbTzN8R';

  private baseApiUrl = window.location.protocol +
                         '//' + window.location.hostname +
                         ':8182/api/index.php/';

  constructor(private http: Http) {}

  public getUpComingEvents() {
    return this.http.get(this.baseApiUrl + 'upcomingevents')
      .toPromise()
      .then((data: any) => {
        return data.json();
      })
      .catch((error) => {
        console.log(error);
      });
  }

  public getCommunity() {
    return this.http.get(this.baseApiUrl + 'activeusers')
      .toPromise()
      .then((data: any) => {
        return data.json();
      })
      .catch((error) => {
        console.log(error);
      });
  }

  public createUser(user: any) {
    console.log(user);
    return this.http.post(
      this.baseApiUrl + 'register',
      JSON.stringify(user),
      { headers: this.headers }
    )
      .toPromise()
      .then((data: any) => {
        return data.json();
      })
      .catch((error) => {
        console.log(error);
      });
  }

  public login(user: any) {
    console.log(user);
    this.headers.append('Authorization', 'Basic ' + btoa(JSON.stringify(user)));
    // console.log(this.headers);
    return this.http.post(
      this.baseApiUrl + 'login',
      '',
      { headers: this.headers }
    )
      .toPromise()
      .then((resp: any) => {
        let data = resp.json();
        this.token = data.data.token;
        return data;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  public requestResetPassword(params: any): any {
    return this.http.post(
      this.baseApiUrl + 'requestcode',
      JSON.stringify(params),
      { headers: this.headers }
    )
      .toPromise()
      .then((data: any) => {
        return data.json();
      })
      .catch((error) => {
        console.log(error);
      });
  }

  public changePassword(params: any): any {
    return this.http.post(
      this.baseApiUrl + 'changepassword',
      JSON.stringify(params),
      { headers: this.headers }
    )
      .toPromise()
      .then((data: any) => {
        return data.json();
      })
      .catch((error) => {
        console.log(error);
      });
  }

  public getProfile() {
    this.headers.set('Authorization', 'Bearer ' + this.token);
    return this.http.get(
      this.baseApiUrl + 'getprofile',
      { headers: this.headers }
    ).toPromise()
    .then((resp) => {
      return resp.json().data;
    });
  }

  public getPlaces() {
    return this.http.get(
      this.baseApiUrl + 'getplaces',
      { headers: this.headers }
    ).toPromise()
    .then((resp) => {
      return resp.json().data;
    });
  }
}
