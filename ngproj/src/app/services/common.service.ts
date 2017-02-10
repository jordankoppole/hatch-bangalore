import { Headers, Http } from '@angular/http';
import { Injectable } from '@angular/core';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class CommonService {
  // private headers = new Headers(
  //   {
  //     'Content-Type': 'application/json',
  //     'Access-Control-Allow-Origin': '*'
  //   }
  // );

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
}
