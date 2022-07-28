import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { RivistaService } from 'src/app/services/rivista.service';

@Component({
  selector: 'app-rivista',
  templateUrl: './rivista.component.html',
  styleUrls: ['./rivista.component.scss'],
})
export class RivistaComponent implements OnInit {
  rivista: any = null;

  constructor(
    private rivistaService: RivistaService,
    private router: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      this.rivistaService.get(slug).subscribe((response: any) => {
        this.rivista = response.data;
        console.log(response);
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }

  newComment(comment: any) {
    this.rivista.comments.push(comment);
  }
}
