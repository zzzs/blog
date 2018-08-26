<script type="text/template" id="comment-template">
  <div id="con-<%= comment_id %>" class="article-con<%if(status === 0){%> comment_wait<%}%><%if(pid !== 0){%> article-con-child<%}%>">
    <div class="nickname">

      <h3>
        <b>
          <%if(guest.website != "" && guest.website != null){%>
          <a href="<%= guest.website %>" target="_blank"><%= guest.nickname %></a>
          <%} else {%>
          <%= guest.nickname %>
          <%}%>
        </b>
      </h3>

      <h6><%= created_at %></h6>
    </div>
    <div class="content">
      <p><%= content %></p>
    </div>
    <div class="reply">
      <a data-toggle="modal" data-target="#commentModal" data-comid="<%= comment_id %>">回复</a>
    </div>
  </div>
</script>
