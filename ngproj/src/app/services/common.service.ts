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
  constructor(private http: Http) {}

  public getUpComingEvents() {
    return this.http.get('http://localhost:8182/api/index.php/upcomingevents')
    .toPromise()
    .then((data: any) => {
      return data.json();
    })
    .catch((error) => {
      console.log(error);
    });
  }
}
